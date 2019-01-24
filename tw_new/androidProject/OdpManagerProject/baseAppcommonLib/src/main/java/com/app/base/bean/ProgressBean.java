package com.app.base.bean;

/**
 * 部门-人-进度
 */

public class ProgressBean {


    /**
     * task_detail_id : 3
     * task_id : 2
     * task_catcher : ui
     * task_progress : -1
     * task_member_id : 2
     * status : -1
     * real_name : 王进
     */

    private String task_procedure_id;
    private String task_id;
    private String task_catcher;
    private String task_progress;
    private String task_member_id;
    private int status;//status :  -1 放弃流程 ,0 未接手, 1 已接手, 2.已完成
    private String real_name;
    private String task_score;
    private String department_name;

    public String getTask_score() {
        return task_score;
    }

    public void setTask_score(String task_score) {
        this.task_score = task_score;
    }

    public String getDepartment_name() {
        return department_name;
    }

    public void setDepartment_name(String department_name) {
        this.department_name = department_name;
    }

    public String getTask_procedure_id() {
        return task_procedure_id;
    }

    public void setTask_procedure_id(String task_procedure_id) {
        this.task_procedure_id = task_procedure_id;
    }

    public String getTask_id() {
        return task_id;
    }

    public void setTask_id(String task_id) {
        this.task_id = task_id;
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

    public String getTask_member_id() {
        return task_member_id;
    }

    public void setTask_member_id(String task_member_id) {
        this.task_member_id = task_member_id;
    }

    public int getStatus() {
        return status;
    }

    public void setStatus(int status) {
        this.status = status;
    }

    public String getReal_name() {
        return real_name;
    }

    public void setReal_name(String real_name) {
        this.real_name = real_name;
    }
}
