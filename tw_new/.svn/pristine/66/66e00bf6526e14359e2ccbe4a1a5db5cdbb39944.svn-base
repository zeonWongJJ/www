package com.app.base.bean;

import com.activeandroid.Model;
import com.activeandroid.annotation.Column;
import com.activeandroid.annotation.Table;
import com.activeandroid.query.Delete;
import com.activeandroid.query.Select;

import java.io.Serializable;
import java.util.List;


@Table(name = "User")
public class User extends Model implements Serializable {

    @Column(name = "userId")
    private String userId;

    @Column(name = "userName")
    private String userName;

    @Column(name = "password")
    private String password;

    @Column(name = "saveTime")
    private long saveTime;

    @Column(name = "isNeedLogin")
    private boolean isNeedLogin;

    public boolean isNeedLogin() {
        return isNeedLogin;
    }

    public void setNeedLogin(boolean needLogin) {
        isNeedLogin = needLogin;
    }

    public long getSaveTime() {
        return saveTime;
    }

    public void setSaveTime(long saveTime) {
        this.saveTime = saveTime;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
    }

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

    public static User getUser(String userId) {
        return new Select()
                .from(User.class)
                .where("userId = ?",userId)
                .executeSingle();
    }
    public static List<User> getUserList() {
        return new Select()
                .from(User.class)./*limit(5).*/orderBy("saveTime DESC").execute();
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

    //List<UserEntity> list = select.from(UserEntity.class).where("").and("").as("").groupBy("").having("").offset("").limit("").execute();


    /*/**
     * 数据库保存数据
     */
    private  void saveData(){
        /*保存数据有两种方式：单挑模式和批量插入模式，批量模式建议使用事务*/
        /*ActiveAndroid.beginTransaction();
        try {
            for (int i=0;i<10;i++){
                Hero hero=new Hero();
                hero.name="李白"+i;
                hero.type="诗人"+i;
                hero.power=i*10;
                hero.save();
            }
            ActiveAndroid.setTransactionSuccessful();
            Toast.makeText(MainActivity.this,"插入数据ok",Toast.LENGTH_SHORT).show();
        }catch (Exception e){
            e.printStackTrace();
        }finally {
            ActiveAndroid.endTransaction();
        }*/
    }

}
