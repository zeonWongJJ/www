package com.app.base.bean;

import java.util.List;

/**
 * 计划评论
 */

public class PlanComment {

    private int position;

    public int getPosition() {
        return position;
    }

    public void setPosition(int position) {
        this.position = position;
    }

    /**
     * plan_record_id : 1
     * plan_id : 18
     * parent_id : 0
     * member_id : 2
     * reply_id : 0
     * plan_record_desc : 李小龙计划点评
     * plan_record_file : uploadfile/image/20180621134417_918.png,uploadfile/image/20180621134417_142.png
     * plan_record_pic : uploadfile/application/20180621134421_878.pdf
     * plan_record_add_time : 1529561449
     * plan_record_add_date : 2018-06-21 14:10
     * my_name : 王进
     * sub : []
     * plan_record_file_data : ["uploadfile/image/20180621134417_918.png","uploadfile/image/20180621134417_142.png"]
     * plan_record_pic_data : ["uploadfile/application/20180621134421_878.pdf"]
     */

    private String plan_record_id;
    private String plan_id;
    private String parent_id;
    private String member_id;
    private String reply_id;
    private String plan_record_desc;
    private String plan_record_file;
    private String plan_record_pic;
    private String plan_record_add_time;
    private String plan_record_add_date;
    private String my_name;
    private List<PlanComment> sub;
    private List<String> plan_record_file_data;
    private List<String> plan_record_pic_data;
    private String reply_name;

    public String getReply_name() {
        return reply_name;
    }

    public void setReply_name(String reply_name) {
        this.reply_name = reply_name;
    }

    public String getPlan_record_id() {
        return plan_record_id;
    }

    public void setPlan_record_id(String plan_record_id) {
        this.plan_record_id = plan_record_id;
    }

    public String getPlan_id() {
        return plan_id;
    }

    public void setPlan_id(String plan_id) {
        this.plan_id = plan_id;
    }

    public String getParent_id() {
        return parent_id;
    }

    public void setParent_id(String parent_id) {
        this.parent_id = parent_id;
    }

    public String getMember_id() {
        return member_id;
    }

    public void setMember_id(String member_id) {
        this.member_id = member_id;
    }

    public String getReply_id() {
        return reply_id;
    }

    public void setReply_id(String reply_id) {
        this.reply_id = reply_id;
    }

    public String getPlan_record_desc() {
        return plan_record_desc;
    }

    public void setPlan_record_desc(String plan_record_desc) {
        this.plan_record_desc = plan_record_desc;
    }

    public String getPlan_record_file() {
        return plan_record_file;
    }

    public void setPlan_record_file(String plan_record_file) {
        this.plan_record_file = plan_record_file;
    }

    public String getPlan_record_pic() {
        return plan_record_pic;
    }

    public void setPlan_record_pic(String plan_record_pic) {
        this.plan_record_pic = plan_record_pic;
    }

    public String getPlan_record_add_time() {
        return plan_record_add_time;
    }

    public void setPlan_record_add_time(String plan_record_add_time) {
        this.plan_record_add_time = plan_record_add_time;
    }

    public String getPlan_record_add_date() {
        return plan_record_add_date;
    }

    public void setPlan_record_add_date(String plan_record_add_date) {
        this.plan_record_add_date = plan_record_add_date;
    }

    public String getMy_name() {
        return my_name;
    }

    public void setMy_name(String my_name) {
        this.my_name = my_name;
    }

    public List<PlanComment> getSub() {
        return sub;
    }

    public void setSub(List<PlanComment> sub) {
        this.sub = sub;
    }

    public List<String> getPlan_record_file_data() {
        return plan_record_file_data;
    }

    public void setPlan_record_file_data(List<String> plan_record_file_data) {
        this.plan_record_file_data = plan_record_file_data;
    }

    public List<String> getPlan_record_pic_data() {
        return plan_record_pic_data;
    }

    public void setPlan_record_pic_data(List<String> plan_record_pic_data) {
        this.plan_record_pic_data = plan_record_pic_data;
    }
}
