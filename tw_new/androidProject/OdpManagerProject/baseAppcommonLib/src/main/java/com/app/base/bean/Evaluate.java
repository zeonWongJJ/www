package com.app.base.bean;

/**
 * 评定 绩效页面
 */

public class Evaluate {
    private String title;
    private String type;
    private String date;
    /**
     * work_id : 3
     * work_status : 正常
     * work_time : 08:18:08
     * unwork_time : 21:33:34
     * score : 6
     * member_id : 2
     * work_date : 2018.06.01
     */

    private String work_id;
    private String work_status;
    private String work_time;
    private String unwork_time;
    private String score;
    private String member_id;
    private String work_date;

    public String getType() {
        return type;
    }

    public void setType(String type) {
        this.type = type;
    }

    public String getDate() {
        return date;
    }

    public void setDate(String date) {
        this.date = date;
    }

    public Evaluate(String title, String type, String date) {
        this.title = title;
        this.type = type;
        this.date = date;
    }

    public String getTitle() {
        return title;
    }

    public void setTitle(String title) {
        this.title = title;
    }


    public String getWork_id() {
        return work_id;
    }

    public void setWork_id(String work_id) {
        this.work_id = work_id;
    }

    public String getWork_status() {
        return work_status;
    }

    public void setWork_status(String work_status) {
        this.work_status = work_status;
    }

    public String getWork_time() {
        return work_time;
    }

    public void setWork_time(String work_time) {
        this.work_time = work_time;
    }

    public String getUnwork_time() {
        return unwork_time;
    }

    public void setUnwork_time(String unwork_time) {
        this.unwork_time = unwork_time;
    }

    public String getScore() {
        return score;
    }

    public void setScore(String score) {
        this.score = score;
    }

    public String getMember_id() {
        return member_id;
    }

    public void setMember_id(String member_id) {
        this.member_id = member_id;
    }

    public String getWork_date() {
        return work_date;
    }

    public void setWork_date(String work_date) {
        this.work_date = work_date;
    }
}
