package app.vdao.qidu.bean;


public class Topic {
    private String title;
    private String content;

    private boolean isComMeg;

    public boolean isComMeg() {
        return isComMeg;
    }

    public void setComMeg(boolean comMeg) {
        isComMeg = comMeg;
    }

    public Topic(String title, String content,boolean isComMeg) {
        this.title = title;
        this.content = content;
        this.isComMeg=isComMeg;
    }

    public String getTitle() {
        return title;
    }

    public void setTitle(String title) {
        this.title = title;
    }

    public String getContent() {
        return content;
    }

    public void setContent(String content) {
        this.content = content;
    }
}
