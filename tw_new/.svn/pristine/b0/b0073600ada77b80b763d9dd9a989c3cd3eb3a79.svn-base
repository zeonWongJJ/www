package com.app.base.bean;

import android.content.Context;
import android.util.Log;

import com.app.base.utils.RealmUtils;

import java.io.Serializable;
import java.sql.SQLException;
import java.util.List;

import io.realm.Realm;
import io.realm.RealmChangeListener;
import io.realm.RealmObject;
import io.realm.RealmResults;

/**
 * https://www.jianshu.com/p/37af717761cc
 */

public class UserRealm extends RealmObject implements Serializable{

    private boolean isSelect=false;
    public boolean isSelect() {
        return isSelect;
    }

    public void setSelect(boolean select) {
        isSelect = select;
    }
    /**
     * member_id : 2
     * member_name : wang
     * password : 25f9e794323b453885f5181f1b624d0b
     * real_name : 王
     * mobile_phone :
     * email :
     * wx_openid :
     * status : 1
     * reg_time : 0
     * reg_ip :
     * last_login_ip : 192.168.1.120
     * last_login_time : 1528338864
     * department_did : 0
     */
    //private int isSelf;//0为记录的账号，1为登录的
    private String member_id;
    private String member_name;
    private String password;
    private String real_name;
    private String mobile_phone;
    private String email;
    private String wx_openid;
    private String status;
    private String major;
    private String name;
    private String token;

    public String getMajor() {
        return major;
    }

    public void setMajor(String major) {
        this.major = major;
    }

    public String getMember_id() {
        return member_id;
    }

    public void setMember_id(String member_id) {
        this.member_id = member_id;
    }

    public void setStatus(String status) {
        this.status = status;
    }


    public String getToken() {
        return token;
    }

    public void setToken(String token) {
        this.token = token;
    }

    private String department_id;
    private String department_name;

    public String getDepartment_id() {
        return department_id;
    }

    public void setDepartment_id(String department_id) {
        this.department_id = department_id;
    }

    public String getDepartment_name() {
        return department_name;
    }

    public void setDepartment_name(String department_name) {
        this.department_name = department_name;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    //开启事务的时候记得需要close关闭事务
    //异步插入
    public static void insertUserRealm(final UserRealm userRealm,Realm.Transaction.OnSuccess callbackSuccess,Realm.Transaction.OnError onError){
        Realm mRealm=RealmUtils.getInstance().getRealm();
        mRealm.executeTransactionAsync(new Realm.Transaction() {
            @Override
            public void execute(Realm realm) {
                //先清除旧的
                realm.where(UserRealm.class).equalTo("member_id", userRealm.getMember_id()).findAll().deleteAllFromRealm();
                realm.copyToRealm(userRealm);
            }
        },callbackSuccess,onError);
    }

    public String getStatus() {
        return status;
    }


    private static boolean isExist(final UserRealm userRealm){
        Realm mRealm=RealmUtils.getInstance().getRealm();
        UserRealm object = mRealm.where(UserRealm.class).equalTo("member_id", userRealm.getMember_id()).findFirst();
        if(object==null){
            return false;
        }
        return true;
    }
    //更新数据
    public static void updateUserRealm(final UserRealm userRealm,Realm.Transaction.OnSuccess callbackSuccess,Realm.Transaction.OnError onError) {
        Realm mRealm=RealmUtils.getInstance().getRealm();
        if(isExist(userRealm)){
            mRealm.executeTransactionAsync(new Realm.Transaction() {
                @Override
                public void execute(Realm realm) {
                    UserRealm object = realm.where(UserRealm.class).equalTo("member_id", userRealm.getMember_id()).findFirst();
                    object.setMember_name(userRealm.getMember_name());
                    object.setMajor(userRealm.getMajor());
                    object.setEmail(userRealm.getEmail());
                    object.setMobile_phone(userRealm.getMobile_phone());
                    object.setPassword(userRealm.getPassword());
                    object.setReal_name(userRealm.getReal_name());
                    object.setStatus(userRealm.getStatus());
                }
            },callbackSuccess,onError);
        }

    }

    //删除数据

    //查询所有
    public static void queryAllUserRealm(final QueryDbCallBack<UserRealm> callBack){
        final RealmResults<UserRealm> results = RealmUtils.getInstance().getRealm().where(UserRealm.class).findAllAsync();
        results.addChangeListener(new RealmChangeListener<RealmResults<UserRealm>>() {
            @Override
            public void onChange(RealmResults<UserRealm> element) {
                //element = element.sort("id");
                List<UserRealm> objects = RealmUtils.getInstance().getRealm().copyFromRealm(element);
                callBack.querySuccess(objects, false);
                results.removeAllChangeListeners();
            }
        });
    }


    public String getMember_name() {
        return member_name;
    }

    public void setMember_name(String member_name) {
        this.member_name = member_name;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public String getReal_name() {
        return real_name;
    }

    public void setReal_name(String real_name) {
        this.real_name = real_name;
    }

    public String getMobile_phone() {
        return mobile_phone;
    }

    public void setMobile_phone(String mobile_phone) {
        this.mobile_phone = mobile_phone;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public String getWx_openid() {
        return wx_openid;
    }

    public void setWx_openid(String wx_openid) {
        this.wx_openid = wx_openid;
    }

    public interface QueryDbCallBack<T>{
        void querySuccess(List<T> items, boolean hasMore);
    }

    private interface SearchExistCallBack {
        void findResult(boolean isExist);
    }



        /*
    * 异步插入User
    * @param user 需要添加的用户对象
    * @throws SQLException
    */
    /*public static void insertUserAsync(final UserRealm user) throws SQLException {
            //一个Realm只能在同一个线程访问，在子线程中进行数据库操作必须重新获取realm对象
            Realm mRealm=RealmUtils.getInstance().getRealm();
            mRealm.executeTransaction(new Realm.Transaction() {
                @Override
                public void execute(Realm realm) {
                        realm.beginTransaction();//开启事务
                        UserRealm user1 = realm.copyToRealm(user);
                        realm.commitTransaction();
                        realm.close();//记得关闭事务
                 }
            });
            mRealm.close();//外面也不能忘记关闭事务
    }*/

        //同步删除
    public static void deleteById(int member_id) throws SQLException{
        Realm mRealm=RealmUtils.getInstance().getRealm();
        mRealm.beginTransaction();
        mRealm.where(UserRealm.class).equalTo("member_id", member_id).findAll().deleteAllFromRealm();
        mRealm.commitTransaction();
        mRealm.close();
    }

    /**
     * 添加(性能优于下面的saveOrUpdateBatch（）方法)
     *
     * @param list
     * @return 批量保存是否成功
     */
    public static boolean insert(List<UserRealm> list) {
        Realm realm= RealmUtils.getInstance().getRealm();
        try {
            realm.beginTransaction();
            realm.insert(list);
            realm.commitTransaction();
            return true;
        } catch (Exception e) {
            e.printStackTrace();
            realm.cancelTransaction();
            return false;
        }
    }
    //同步删除
    public static void deleteAll() throws SQLException{
        Realm mRealm=RealmUtils.getInstance().getRealm();
        mRealm.beginTransaction();
        mRealm.where(UserRealm.class).findAll().deleteAllFromRealm();
        mRealm.commitTransaction();
        mRealm.close();
    }

    public static void deleteAllUserRealm(Context context){
        final Realm mRealm=RealmUtils.getInstance().getRealm();
        mRealm.executeTransactionAsync(new Realm.Transaction() {
            @Override
            public void execute(Realm realm) {
                final RealmResults<UserRealm> dogs=  mRealm.where(UserRealm.class).findAll();
                //删除所有数据
                dogs.deleteAllFromRealm();
            }
        }, new Realm.Transaction.OnSuccess() {
            @Override
            public void onSuccess() {

            }
        }, new Realm.Transaction.OnError() {
            @Override
            public void onError(Throwable error) {

            }
        });
        /*mRealm.executeTransaction(new Realm.Transaction() {
            @Override
            public void execute(Realm realm) {

                Dog dog=dogs.get(5);
                dog.deleteFromRealm();
                //删除第一个数据
                dogs.deleteFirstFromRealm();
                //删除最后一个数据
                dogs.deleteLastFromRealm();
                //删除位置为1的数据
                dogs.deleteFromRealm(1);
                //删除所有数据
                dogs.deleteAllFromRealm();
            }
        });*/
    }


    /*
    * //增序排列
        dogs=dogs.sort("id");
        //降序排列
        dogs=dogs.sort("id", Sort.DESCENDING);
User user = mRealm.where(User.class)
128                 .equalTo("name",name1)//相当于where name = name1
129                 .or()//或，连接查询条件，没有这个方式时会默认是&连接
130                 .equalTo("age",age1)//相当于where age = age1
131                 .findFirst();
132         //整体相当于select * from (表名) where name = (传入的name) or age = （传入的age）limit 1;
        */
}
