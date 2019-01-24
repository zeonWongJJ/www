package app.vdaoadmin.qidu.bean;

/**
 * Created by 7du-28 on 2018/4/26.
 */

public class MessageBean {
    private String mess_id;
    private String ues_id;
    private String ues_name;
    private String content;
    private long mess_time;
    private String examine;

    public String getMess_id() {
        return mess_id;
    }

    public void setMess_id(String mess_id) {
        this.mess_id = mess_id;
    }

    public String getUes_id() {
        return ues_id;
    }

    public void setUes_id(String ues_id) {
        this.ues_id = ues_id;
    }

    public String getUes_name() {
        return ues_name;
    }

    public void setUes_name(String ues_name) {
        this.ues_name = ues_name;
    }

    public String getContent() {
        return content;
    }

    public void setContent(String content) {
        this.content = content;
    }

    public long getMess_time() {
        return mess_time;
    }

    public void setMess_time(long mess_time) {
        this.mess_time = mess_time;
    }

    public String getExamine() {
        return examine;
    }

    public void setExamine(String examine) {
        this.examine = examine;
    }
}
