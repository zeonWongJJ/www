package com.app.base.bean;

/**
 * Created by 7du-28 on 2018/6/23.
 */

public class SystemNotice {


    /**
     * id : 19
     * belong_id : 12
     * notice_type :
     * is_read : 0
     * notice_publisher_name : 王进
     * post_add : 2018-06-27 17:35
     * notice_connect : 各位同事： 	大家好，先决定为了让大家纪念屈原，端午放假。端午节与春节、清明节、中秋节并成为中国民间的四大传统节日。[3]自古以来端午节便有划龙舟及食粽等节日活动。2018年起，端午节被列为国家法定节日，2006年5月，国务院将其列入首批国家级非物质文化遗产名录联合国教科文组织正式审议并批准中国端午节进入世界非物质文化遗产。
     */

    private String id;
    private String belong_id;
    private String notice_type;
    private String is_read;
    private String notice_publisher_name;
    private String post_add;
    private String connect;

    public String getId() {
        return id;
    }

    public void setId(String id) {
        this.id = id;
    }

    public String getBelong_id() {
        return belong_id;
    }

    public void setBelong_id(String belong_id) {
        this.belong_id = belong_id;
    }

    public String getNotice_type() {
        return notice_type;
    }

    public void setNotice_type(String notice_type) {
        this.notice_type = notice_type;
    }

    public String getIs_read() {
        return is_read;
    }

    public void setIs_read(String is_read) {
        this.is_read = is_read;
    }

    public String getNotice_publisher_name() {
        return notice_publisher_name;
    }

    public void setNotice_publisher_name(String notice_publisher_name) {
        this.notice_publisher_name = notice_publisher_name;
    }

    public String getPost_add() {
        return post_add;
    }

    public void setPost_add(String post_add) {
        this.post_add = post_add;
    }

    public String getConnect() {
        return connect;
    }

    public void setConnect(String connect) {
        this.connect = connect;
    }
}
