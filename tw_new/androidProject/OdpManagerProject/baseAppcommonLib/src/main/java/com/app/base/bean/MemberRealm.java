package com.app.base.bean;

import com.app.base.utils.RealmUtils;

import java.io.Serializable;
import java.sql.SQLException;
import java.util.List;

import io.realm.Realm;
import io.realm.RealmObject;

/**
 * MemberRealm 只用作当前登陆用户信息记录
 */

public class MemberRealm extends RealmObject implements Serializable {

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
    private String department_name;

    public String getMajor() {
        return major;
    }

    public void setMajor(String major) {
        this.major = major;
    }

    public String getDepartment_name() {
        return department_name;
    }

    public void setDepartment_name(String department_name) {
        this.department_name = department_name;
    }

    public String getMember_id() {
        return member_id;
    }

    public void setMember_id(String member_id) {
        this.member_id = member_id;
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

    public String getStatus() {
        return status;
    }

    public void setStatus(String status) {
        this.status = status;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getToken() {
        return token;
    }

    public void setToken(String token) {
        this.token = token;
    }

    public static void insertMemberRealm(final MemberRealm userRealm, Realm.Transaction.OnSuccess callbackSuccess, Realm.Transaction.OnError onError){
        Realm mRealm=RealmUtils.getInstance().getRealm();
        mRealm.executeTransactionAsync(new Realm.Transaction() {
            @Override
            public void execute(Realm realm) {
                //先清除旧的
                realm.where(MemberRealm.class).equalTo("member_id", userRealm.getMember_id()).findAll().deleteAllFromRealm();
                realm.copyToRealm(userRealm);
            }
        },callbackSuccess,onError);
    }
    public static void deleteAllAsync(Realm.Transaction.OnSuccess callbackSuccess, Realm.Transaction.OnError onError){
        Realm mRealm=RealmUtils.getInstance().getRealm();
        mRealm.executeTransactionAsync(new Realm.Transaction() {
            @Override
            public void execute(Realm realm) {
                realm.where(UserRealm.class).findAll().deleteAllFromRealm();
            }
        },callbackSuccess,onError);
    }
    //同步删除
    public static void deleteAll() throws SQLException {
        Realm mRealm=RealmUtils.getInstance().getRealm();
        try {
            mRealm.beginTransaction();
            mRealm.where(UserRealm.class).findAll().deleteAllFromRealm();
            mRealm.commitTransaction();
            mRealm.close();
        } catch (Exception e) {
            e.printStackTrace();

        }
    }
    public boolean insert(RealmObject object) {
        Realm realm= RealmUtils.getInstance().getRealm();
        try {
            realm.beginTransaction();
            realm.insert(object);
            realm.commitTransaction();
            return true;
        } catch (Exception e) {
            e.printStackTrace();
            realm.cancelTransaction();
            return false;
        }
    }
    /**
     * 添加(性能优于下面的saveOrUpdateBatch（）方法)
     *
     * @param list
     * @return 批量保存是否成功
     */
    public boolean insert(List<MemberRealm> list) {
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


    public List<MemberRealm> findAll(){
        Realm realm= RealmUtils.getInstance().getRealm();
        List<MemberRealm> list=realm.where(MemberRealm.class)/*.beginGroup().equalTo().endGroup()*/.findAll();
        return list;
    }
}
