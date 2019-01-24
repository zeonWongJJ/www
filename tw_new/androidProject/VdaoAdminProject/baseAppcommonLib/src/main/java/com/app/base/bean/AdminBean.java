package com.app.base.bean;

import com.activeandroid.Model;
import com.activeandroid.annotation.Column;
import com.activeandroid.annotation.Table;
import com.activeandroid.query.Delete;
import com.activeandroid.query.Select;

/**
 * Created by 7du-28 on 2018/4/26.
 */
@Table(name = "AdminBean")
public class AdminBean extends Model{
    @Column(name = "admin_id")
    private String admin_id;
    @Column(name = "admin_name")
    private String admin_name;
    @Column(name = "admin_sex")
    private String admin_sex;
    @Column(name = "admin_realname")
    private String admin_realname;
    @Column(name = "admin_phone")
    private String admin_phone;
    @Column(name = "admin_email")
    private String admin_email;
    @Column(name = "role_id")
    private String role_id;
    @Column(name = "admin_state")
    private String admin_state;


    @Column(name = "token")
    private String token;

    public String getToken() {
        return token;
    }

    public void setToken(String token) {
        this.token = token;
    }
    public static AdminBean getAdminBean() {
        return new Select()
                .from(AdminBean.class)
                .executeSingle();
    }
    public static void deleteAdminBean(){
        new Delete().from(AdminBean.class).execute();
    }
    public String getAdmin_id() {
        return admin_id;
    }

    public void setAdmin_id(String admin_id) {
        this.admin_id = admin_id;
    }

    public String getAdmin_name() {
        return admin_name;
    }

    public void setAdmin_name(String admin_name) {
        this.admin_name = admin_name;
    }

    public String getAdmin_sex() {
        return admin_sex;
    }

    public void setAdmin_sex(String admin_sex) {
        this.admin_sex = admin_sex;
    }

    public String getAdmin_realname() {
        return admin_realname;
    }

    public void setAdmin_realname(String admin_realname) {
        this.admin_realname = admin_realname;
    }

    public String getAdmin_phone() {
        return admin_phone;
    }

    public void setAdmin_phone(String admin_phone) {
        this.admin_phone = admin_phone;
    }

    public String getAdmin_email() {
        return admin_email;
    }

    public void setAdmin_email(String admin_email) {
        this.admin_email = admin_email;
    }

    public String getRole_id() {
        return role_id;
    }

    public void setRole_id(String role_id) {
        this.role_id = role_id;
    }

    public String getAdmin_state() {
        return admin_state;
    }

    public void setAdmin_state(String admin_state) {
        this.admin_state = admin_state;
    }
}
