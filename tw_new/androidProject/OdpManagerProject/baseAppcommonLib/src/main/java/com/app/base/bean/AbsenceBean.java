package com.app.base.bean;

import java.util.List;

/**
 * 请假信息
 */

public class AbsenceBean {


    /**
     * absence_id : 3
     * member_id : 2
     * is_pass : 同意
     * absence_status : 调休
     * absence_start_time : 2018-06-19 03:12
     * absence_end_time : 2018-06-21 06:59
     * absence_ask_time : 2018-06-19 16:24
     * absence_desc : 啊啊啊啊阿
     */
    //拿列表的时候使用
    private List<AbsenceBean> absence_records;

    public List<AbsenceBean> getAbsence_records() {
        return absence_records;
    }

    public void setAbsence_records(List<AbsenceBean> absence_records) {
        this.absence_records = absence_records;
    }

    private String absence_id;
    private String member_id;
    private String is_pass;
    private String absence_status;
    private String absence_start_time;
    private String absence_end_time;
    private String absence_ask_time;
    private String absence_desc;
    private String real_name;

    private String absence_approval_superior;
    private String superior_name;

    public String getAbsence_approval_superior() {
        return absence_approval_superior;
    }

    public void setAbsence_approval_superior(String absence_approval_superior) {
        this.absence_approval_superior = absence_approval_superior;
    }

    public String getSuperior_name() {
        return superior_name;
    }

    public void setSuperior_name(String superior_name) {
        this.superior_name = superior_name;
    }

    public String getReal_name() {
        return real_name;
    }

    public void setReal_name(String real_name) {
        this.real_name = real_name;
    }

    public String getAbsence_id() {
        return absence_id;
    }

    public void setAbsence_id(String absence_id) {
        this.absence_id = absence_id;
    }

    public String getMember_id() {
        return member_id;
    }

    public void setMember_id(String member_id) {
        this.member_id = member_id;
    }

    public String getIs_pass() {
        return is_pass;
    }

    public void setIs_pass(String is_pass) {
        this.is_pass = is_pass;
    }

    public String getAbsence_status() {
        return absence_status;
    }

    public void setAbsence_status(String absence_status) {
        this.absence_status = absence_status;
    }

    public String getAbsence_start_time() {
        return absence_start_time;
    }

    public void setAbsence_start_time(String absence_start_time) {
        this.absence_start_time = absence_start_time;
    }

    public String getAbsence_end_time() {
        return absence_end_time;
    }

    public void setAbsence_end_time(String absence_end_time) {
        this.absence_end_time = absence_end_time;
    }

    public String getAbsence_ask_time() {
        return absence_ask_time;
    }

    public void setAbsence_ask_time(String absence_ask_time) {
        this.absence_ask_time = absence_ask_time;
    }

    public String getAbsence_desc() {
        return absence_desc;
    }

    public void setAbsence_desc(String absence_desc) {
        this.absence_desc = absence_desc;
    }
}
