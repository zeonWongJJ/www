package com.gzqx.common.bean;

import com.activeandroid.Model;
import com.activeandroid.annotation.Column;
import com.activeandroid.annotation.Table;
import com.activeandroid.query.Delete;
import com.activeandroid.query.Select;
import com.gzqx.common.sysutil.AppUtils;

import java.io.Serializable;
import java.util.List;


@Table(name = "User")
public class User extends Model implements Serializable {

    @Column(name = "userId")
    private String userId;

    @Column(name = "userName")
    private String userName;


    public String getUserId() {
        return userId;
    }

    public String getUserName() {
        return userName;
    }

    public void setUserName(String userName) {
        this.userName = userName;
    }

    public void setUserId(String userId) {
        this.userId = userId;
    }

    public static User getUser() {
        return new Select()
                .from(User.class)
                //.where("name = ?", user.getName())
                .executeSingle();
    }
    public static List<User> getUserList() {
        return new Select()
                .from(User.class)./*limit(5).*/execute();
    }
    public static void deleteUser(String userId){
        new Delete().from(User.class).where("userId = ?", userId).execute();
    }
    //判断账号是否存在
    public static boolean isExistUserByUserId(String userId) {
        User user=new Select()
                .from(User.class).where("userId = ?", userId).executeSingle();
        return user!=null?true:false;
    }
    //包含手机本地注册过的账号设备id是否存在
    /*public static boolean isExistDeviceId(){
        User user=new Select().from(User.class).where("equipmentId = ?", AppUtils.generateDeviceUniqueId()).executeSingle();
        return user!=null?true:false;
    }*/
}
