package com.app.base.bean;

/**
 * 动态评论消息
 */

public class DynamicCommentRecord {


    /**
     * id : 7
     * type : 1
     * dynamic_id : 20
     * floor_host_id : 3
     * storey_id : 14
     * status : 0
     * add_time : 1533199543
     * storey_name : 江周辉
     * dynamic : {"id":"20","parent_id":"0","member_id":"3","reply_id":"0","content":"发布帖子","forwarded_id":"0","pic":"uploadfile/image/20180801194358_818.png,uploadfile/image/20180801194358_378.png,uploadfile/image/20180801194359_113.png,uploadfile/image/20180801194358_846.png,uploadfile/image/20180801194359_658.png","likes":"1","add_time":"1533123858"}
     */

    private String id;
    private String type;
    private String dynamic_id;
    private String floor_host_id;
    private String storey_id;
    private String status;
    private String add_time;
    private String storey_name;
    private DynamicComment dynamic;
    private String add_date;
    private String content;

    public String getContent() {
        return content;
    }

    public void setContent(String content) {
        this.content = content;
    }

    public String getAdd_date() {
        return add_date;
    }

    public void setAdd_date(String add_date) {
        this.add_date = add_date;
    }

    public String getId() {
        return id;
    }

    public void setId(String id) {
        this.id = id;
    }

    public String getType() {
        return type;
    }

    public void setType(String type) {
        this.type = type;
    }

    public String getDynamic_id() {
        return dynamic_id;
    }

    public void setDynamic_id(String dynamic_id) {
        this.dynamic_id = dynamic_id;
    }

    public String getFloor_host_id() {
        return floor_host_id;
    }

    public void setFloor_host_id(String floor_host_id) {
        this.floor_host_id = floor_host_id;
    }

    public String getStorey_id() {
        return storey_id;
    }

    public void setStorey_id(String storey_id) {
        this.storey_id = storey_id;
    }

    public String getStatus() {
        return status;
    }

    public void setStatus(String status) {
        this.status = status;
    }

    public String getAdd_time() {
        return add_time;
    }

    public void setAdd_time(String add_time) {
        this.add_time = add_time;
    }

    public String getStorey_name() {
        return storey_name;
    }

    public void setStorey_name(String storey_name) {
        this.storey_name = storey_name;
    }

    public DynamicComment getDynamic() {
        return dynamic;
    }

    public void setDynamic(DynamicComment dynamic) {
        this.dynamic = dynamic;
    }


}
