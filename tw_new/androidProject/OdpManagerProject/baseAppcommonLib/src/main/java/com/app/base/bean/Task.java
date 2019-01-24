package com.app.base.bean;

import java.util.List;

/**
 * 任务实体类
 */

public class Task {




    private int id;
    private String name;

    /**
     * task_id : 1
     * task_title : 这是我的任务标题
     * task_desc : dsgfdg
     * task_project_ids : 2,3,4
     * task_plan_ids : 2,3,4
     * task_belonged :
     * task_time_limit : 1529424000
     * task_file :
     * task_pic :
     * task_member_id : 0
     * task_add_time : 1528339669
     * task_catcher : {"fed":{"member_id":"2","real_name":"\u738b"},"php":{"member_id":"2","real_name":"\u738b"},"ios":{"member_id":"2","real_name":"\u738b"}}
     * task_progress : {"fed":0,"php":100,"ios":0}
     * task_project_names : V稻,ODP,家洁
     * task_date_limit : 2018-06-20
     * task_add_date : 2018-06-07
     */

    private String task_id;
    private String task_title;
    private String task_desc;
    private String task_project_ids;
    private String task_plan_ids;
    private String task_belonged;
    private String task_time_limit;
    private String task_file;
    private String task_pic;
    private String task_member_id;
    private String task_add_time;
    private String task_catcher;
    private String task_progress;
    private String task_project_names;
    private String task_date_limit;
    private String task_add_date;
    private List<Project> task_project_ids_data;
    private List<ProgressBean> task_procedures;
    private String task_record_total;
    private String nav;

    public String getNav() {
        return nav;
    }

    public void setNav(String nav) {
        this.nav = nav;
    }

    private List<Plan> task_plan_ids_data;

    private String task_structure_id;//节点id

    public String getTask_structure_id() {
        return task_structure_id;
    }

    public void setTask_structure_id(String task_structure_id) {
        this.task_structure_id = task_structure_id;
    }

    public List<Plan> getTask_plan_ids_data() {
        return task_plan_ids_data;
    }

    public void setTask_plan_ids_data(List<Plan> task_plan_ids_data) {
        this.task_plan_ids_data = task_plan_ids_data;
    }

    private List<String> task_file_urls;
    private List<String> task_pic_urls;

    public List<String> getTask_file_urls() {
        return task_file_urls;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getTask_id() {
        return task_id;
    }

    public void setTask_id(String task_id) {
        this.task_id = task_id;
    }

    public String getTask_time_limit() {
        return task_time_limit;
    }

    public void setTask_time_limit(String task_time_limit) {
        this.task_time_limit = task_time_limit;
    }

    public String getTask_member_id() {
        return task_member_id;
    }

    public void setTask_member_id(String task_member_id) {
        this.task_member_id = task_member_id;
    }

    public String getTask_add_time() {
        return task_add_time;
    }

    public void setTask_add_time(String task_add_time) {
        this.task_add_time = task_add_time;
    }

    public void setTask_file_urls(List<String> task_file_urls) {
        this.task_file_urls = task_file_urls;
    }

    public List<String> getTask_pic_urls() {
        return task_pic_urls;
    }

    public void setTask_pic_urls(List<String> task_pic_urls) {
        this.task_pic_urls = task_pic_urls;
    }

    //private List<UserRealm> task_belonged_member;
    private List<UserRealm> task_belonged_data;

    public List<UserRealm> getTask_belonged_data() {
        return task_belonged_data;
    }

    public void setTask_belonged_data(List<UserRealm> task_belonged_data) {
        this.task_belonged_data = task_belonged_data;
    }

    /*public List<UserRealm> getTask_belonged_member() {
        return task_belonged_member;
    }

    public void setTask_belonged_member(List<UserRealm> task_belonged_member) {
        this.task_belonged_member = task_belonged_member;
    }*/

    public String getTask_record_total() {
        return task_record_total;
    }

    public void setTask_record_total(String task_record_total) {
        this.task_record_total = task_record_total;
    }

    public List<Project> getTask_project_ids_data() {
        return task_project_ids_data;
    }

    public void setTask_project_ids_data(List<Project> task_project_ids_data) {
        this.task_project_ids_data = task_project_ids_data;
    }

    public List<ProgressBean> getTask_procedures() {
        return task_procedures;
    }

    public void setTask_procedures(List<ProgressBean> task_procedures) {
        this.task_procedures = task_procedures;
    }

    public String getTask_title() {
        return task_title;
    }

    public void setTask_title(String task_title) {
        this.task_title = task_title;
    }

    public String getTask_desc() {
        return task_desc;
    }

    public void setTask_desc(String task_desc) {
        this.task_desc = task_desc;
    }

    public String getTask_project_ids() {
        return task_project_ids;
    }

    public void setTask_project_ids(String task_project_ids) {
        this.task_project_ids = task_project_ids;
    }

    public String getTask_plan_ids() {
        return task_plan_ids;
    }

    public void setTask_plan_ids(String task_plan_ids) {
        this.task_plan_ids = task_plan_ids;
    }

    public String getTask_belonged() {
        return task_belonged;
    }

    public void setTask_belonged(String task_belonged) {
        this.task_belonged = task_belonged;
    }



    public String getTask_file() {
        return task_file;
    }

    public void setTask_file(String task_file) {
        this.task_file = task_file;
    }

    public String getTask_pic() {
        return task_pic;
    }

    public void setTask_pic(String task_pic) {
        this.task_pic = task_pic;
    }


    public String getTask_catcher() {
        return task_catcher;
    }

    public void setTask_catcher(String task_catcher) {
        this.task_catcher = task_catcher;
    }

    public String getTask_progress() {
        return task_progress;
    }

    public void setTask_progress(String task_progress) {
        this.task_progress = task_progress;
    }

    public String getTask_project_names() {
        return task_project_names;
    }

    public void setTask_project_names(String task_project_names) {
        this.task_project_names = task_project_names;
    }

    public String getTask_date_limit() {
        return task_date_limit;
    }

    public void setTask_date_limit(String task_date_limit) {
        this.task_date_limit = task_date_limit;
    }

    public String getTask_add_date() {
        return task_add_date;
    }

    public void setTask_add_date(String task_add_date) {
        this.task_add_date = task_add_date;
    }
}
