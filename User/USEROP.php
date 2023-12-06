<?php
    include_once 'databaseInfo.php';

    class USEROP{
        /**********************对外接口函数开始********************/
        /**
         * @param $User 用户名
         * @param $Password 密码
         * @return int 返回-2 数据库操作失败； -1没有此用户，其他数字用户等级
         */
        public function getUserLevel($User,$Password){
            return $this->_getUserLevel($User,$Password);
        }

        /**
         * @param $User 用户名
         * @param $Password 密码
         * @return int 返回-2 数据库操作失败； -1没有此用户，其他数字用户等级
         */
        public function checkUser($User,$Password){
            return $this->_getUserLevel($User,$Password);
        }

        /**
         * @param $User
         * @param $Password
         * @param $Lelvel
         * @return int|string 返回0 添加成功
         */
        public function addUser($User,$Password,$Lelvel){
            return $this->_addUser($User,$Password,$Lelvel);
        }

        /**
         * @param $User
         * @param $OldPassword
         * @param $NewPassword
         * @return int|string 返回0 更改密码成功
         */
        public function updateUserPassword($User,$OldPassword,$NewPassword){
            return $this->_userUpdatePassword($User,$OldPassword,$NewPassword);
        }

        /**********************对外接口函数结束********************/

        /*******************查询用户等级和判断用户是否存在开始******************/
        /**
         * 查询用户等级和判断用户是否存在
         * @param $User 查找的用户
         * @param $Password 用户密码
         * @return int -2 操作数据库失败 ;-1 查无此用户; 其他数字为用户等级
         */
        private function _getUserLevel($User,$Password){
            global $userDatabaseUser, $userDatabasePassword , $userDatabaseName, $userTableName,$adminUserLevel,$normalUserLevel;
            $con = mysql_connect("localhost",$userDatabaseUser,$userDatabasePassword);
            if(!$con){
                return -2; //数据库操作失败
            }
            if(!mysql_select_db($userDatabaseName,$con)){
                mysql_close($con);
                return -2; //数据库操作失败
            }
            $sql = "select Level from ".$userTableName." WHERE User = '$User' AND Password='".md5($Password)."'";
            $sql_res = mysql_query($sql);
            if(mysql_num_rows($sql_res) != 1){
                mysql_close($con);
                return -1; //没有此用户
            }else{
                mysql_close($con);
                return mysql_fetch_array($sql_res)['Level']; //返回用户等级
            }
            mysql_close($con);
        }
        /*******************查询用户等级和判断用户是否存在结束******************/

        /*****************判断用户名是否存在开始****************/
            private function _isUserExist($User){
                global $userDatabaseUser, $userDatabasePassword , $userDatabaseName, $userTableName,$adminUserLevel,$normalUserLevel;
                $con = mysql_connect("localhost",$userDatabaseUser,$userDatabasePassword);
                if(!$con){
                    return -2; //数据库操作失败
                }
                if(!mysql_select_db($userDatabaseName,$con)){
                    mysql_close($con);
                    return -2; //数据库操作失败
                }
                $sql = "select Level from ".$userTableName." WHERE User = '$User'";
                $sql_res = mysql_query($sql);
                if(mysql_num_rows($sql_res) != 1){
                    mysql_close($con);
                    return -1; //没有此用户
                }else{
                    mysql_close($con);
                    return mysql_fetch_array($sql_res)['Level']; //返回用户等级
                }
                mysql_close($con);
            }
        /*****************判断用户名是否存在结束****************/

        /*******************添加新用户开始************************/
        private function _addUser($User,$Password,$Level=4){
            global $userDatabaseUser, $userDatabasePassword , $userDatabaseName, $userTableName,$adminUserLevel,$normalUserLevel;
            $isExist = $this->_isUserExist($User);
            if($isExist != -1 || $isExist == -2){
                return -1;
            }
            $con = mysql_connect("localhost",$userDatabaseUser,$userDatabasePassword);
            if(!$con){
                return -2;
            }
            if(!mysql_select_db($userDatabaseName,$con)){
                mysql_close($con);
                return -3;
            }
            $sql = "insert into ".$userTableName." (User,Password,Level) VALUES ('".$User."','".md5($Password)."',".$Level.")";
            if(!mysql_query($sql)){
                mysql_close($con);
                return -4;
            }
            mysql_close($con);
            return 0;
        }
        /*******************添加新用户结束************************/

        /*******************用户更改密码开始*********************/
        private function  _userUpdatePassword($User,$OldPassword,$NewPassword){
            global $userDatabaseUser, $userDatabasePassword , $userDatabaseName, $userTableName,$adminUserLevel,$normalUserLevel;
            if ($OldPassword == '' or $NewPassword == ''){
                return -4;
            }
            
            $OldPassword1 = md5($OldPassword);
            $NewPassword = md5($NewPassword);
            
            $isExist = $this->_getUserLevel($User,$OldPassword);
            if($isExist == -1 || $isExist == -2){
                return -1;
            }
            $con = mysql_connect("localhost",$userDatabaseUser,$userDatabasePassword);
            if(!$con){
                return -2;
            }
            if(!mysql_select_db($userDatabaseName,$con)){
                mysql_close($con);
                return -3;
            }
            $sql = "UPDATE ".$userTableName." SET Password = "."'".$NewPassword."'"." WHERE User = "."'".$User."' AND"." Password = "."'".$OldPassword1."'";
            if(!mysql_query($sql)){
                mysql_close($con);
                return -4;
            }
            mysql_close($con);
            return 0;
        }
        /*******************用户更改密码开始*********************/
    }
?>
