package redpacket.lib;

import android.app.Activity;
import android.content.Context;
import android.support.annotation.IntDef;

import java.lang.annotation.Retention;
import java.lang.annotation.RetentionPolicy;

/**
 * @Author CaiXi on  2016/12/8 00:33.
 * @Github: https://github.com/cxMax
 * @Description DilaogBean-dialog当前状态，dialog业务接口方法
 */

public class DialogHelper {
    private Activity mContext;

    private DialogHelper() {

    }

    private DialogHelper(Activity context) {
        this.mContext = context;
    }

    public static DialogHelper with(Activity context) {
        return new DialogHelper(context);
    }

    public DialogController begin() {
        return new DialogController(mContext);
    }

    public interface Result {
        void showDilaog(DilaogBean bean);
        void hideDialog();
    }

    public static class DilaogBean {
        static final int STATUS_READY = 0;
        static final int STATUS_ROTATE = 1;

        @DilaogStatus
        private int status = STATUS_READY;

        private String receiveMessage;

        @Retention(RetentionPolicy.SOURCE)
        @IntDef(value = {STATUS_READY, STATUS_ROTATE})
        @interface DilaogStatus {
        }

        public DilaogBean status(int state) {
            this.status = state;
            return this;
        }

        public String getMessageId() {
            return messageId;
        }

        public void setMessageId(String messageId) {
            this.messageId = messageId;
        }
        private int position;
        private String messageId;

        public String getReceiveMessage() {
            return receiveMessage;
        }

        public void setReceiveMessage(String receiveMessage) {
            this.receiveMessage = receiveMessage;
        }

        public int getPosition() {
            return position;
        }

        public void setPosition(int position) {
            this.position = position;
        }

        public int getStatus() {
            return status;
        }
    }
}
