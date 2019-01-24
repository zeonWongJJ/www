package com.app.base.bean;

/**
 * Created by 7du-28 on 2018/1/9.
 */

public class TypeSelect {
    public static String assignTask="assignTask";//指派任务
    public static String unAcceptTask="unAcceptTask";//接手任务
    public static String acceptTask="acceptTask";//接手任务
    public static String giveUpTask="giveUpTask";//放弃任务
    public static String actionRecord="actionRecord";//动作记录
    public static String resetProcedure="resetProcedure";//恢复流程
    public static String cancelProcedure="cancelProcedure";//取消流程
    public static String editProcess="editProcess";//编辑进度
    public static String completeTask="completeTask";//任务完成


    /*计划类型*/
    public static String weekPlan="weekPlan";//周计划
    public static String customizedPlan="customizedPlan";//定制计划
    /*动作类型*/
    public static String diaryAction="diaryAction";//日记
    public static String questionAction="questionAction";//疑问
    public static String proposalAction="proposalAction";//建议
    public static String bugAction="bugAction";//bug



    public static String attendanceBean="attendanceBean";//签到记录
    public static String leaveBean="leaveBean";//请假记录
    public static String approvalBean="approvalBean";//审批记录
    public static String signInBean="signInBean";//签到
    private String type;

    private String title;
    private String status;

    public String getStatus() {
        return status;
    }

    public void setStatus(String status) {
        this.status = status;
    }

    public TypeSelect(String type, String title) {
        this.type = type;
        this.title = title;
    }

    public String getType() {
        return type;
    }

    public void setType(String type) {
        this.type = type;
    }

    public String getTitle() {
        return title;
    }

    public void setTitle(String title) {
        this.title = title;
    }
}
