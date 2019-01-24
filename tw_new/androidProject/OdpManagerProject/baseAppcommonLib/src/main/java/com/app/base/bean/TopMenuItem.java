package com.app.base.bean;

/**
 * Created by 7du-28 on 2018/5/25.
 */

public class TopMenuItem {
    private String title;
    private String action;
    public static String ALL_TASK="allTask";
    public static String MY_TASK="myTask";
    public static String PLAN_TASK="planTask";
    public static String MY_PUBLISH_TASK="my_publish_task";
    public static String BILLBOARD="billboard";

    public TopMenuItem(String title, String action) {
        this.title = title;
        this.action = action;
    }

    public String getTitle() {
        return title;
    }

    public void setTitle(String title) {
        this.title = title;
    }

    public String getAction() {
        return action;
    }

    public void setAction(String action) {
        this.action = action;
    }
}
