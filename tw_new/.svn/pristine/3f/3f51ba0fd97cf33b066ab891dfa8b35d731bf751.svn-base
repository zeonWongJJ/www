package redpacket.lib;

import android.app.Activity;
import android.app.Dialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.SharedPreferences;
import android.util.Log;
import android.view.Display;
import android.view.Gravity;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.luck.picture.lib.rxbus2.RxBus;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

import bean.DefaultEventEntity;
import chat.rocket.android.widget.R;
import chat.rocket.core.utils.CommonKey;

/**
 * @Description dialog具体实现和业务实现
 */

public class DialogController {

    private Activity mContext;

    private View mPopView;
    private TextView userName,markText;

    private ImageView mCloseImg;

    private LinearLayout mContainerFlip;
    private ImageView mBtnFlip;
    private Dialog dialog;
    private View groupShowTip;//多个红包时显示

    //private AnimatorUtil mAnimatorUtil = new AnimatorUtil();

    public DialogController(Activity context) {
        this.mContext = context;
        initPopupWindow();
    }

    private void initPopupWindow() {
        dialog=new Dialog(mContext,R.style.dialog_style);
        //设置style
        //dialog.set
        mPopView = (mContext).getLayoutInflater().inflate(R.layout.red_packet_pop_view, null);
        //放在show()之后，不然有些属性是没有效果的，比如height和width
        Window dialogWindow = dialog.getWindow();
        WindowManager m = mContext.getWindowManager();
        Display d = m.getDefaultDisplay(); // 获取屏幕宽、高用
        WindowManager.LayoutParams p = dialogWindow.getAttributes(); // 获取对话框当前的参数值
//设置高度和宽度
        p.height = (int) (d.getHeight() * 0.6); // 高度设置为屏幕的0.6
        p.width = (int) (d.getWidth() * 0.6); // 宽度设置为屏幕的0.65
//设置位置
        p.gravity = Gravity.CENTER;
//设置透明度
        //p.alpha = 0.5f;
        dialogWindow.setAttributes(p);
        dialog.setContentView(mPopView);
        dialog.setOnDismissListener(new DialogInterface.OnDismissListener() {
            @Override
            public void onDismiss(DialogInterface dialogInterface) {

            }
        });
        initPopView(mPopView);
    }

    private void initPopView(View rootView) {

        mCloseImg = (ImageView) rootView.findViewById(R.id.details_popview_close_img);
        mCloseImg.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                if (dialog != null && dialog.isShowing()) {
                    dialog.dismiss();
                }
            }
        });
        markText=rootView.findViewById(R.id.gift_tips_text_flip);
        userName=rootView.findViewById(R.id.user_name);
        mContainerFlip = (LinearLayout) rootView.findViewById(R.id.details_popview_layout_flip);
        mBtnFlip = rootView.findViewById(R.id.open_red_packet);
        groupShowTip=rootView.findViewById(R.id.gift_details_text_flip);

    }
    public static int receiveHandler=0x111;

    public void showDilaog(final DialogHelper.DilaogBean bean) {
        String response=bean.getReceiveMessage();

        String name="";
        String remark="";
        String money="0.00";
        String redPacketId=null;
        try {
            JSONObject jsonObject=new JSONObject(response);
            name=jsonObject.getString("userName");
            remark=jsonObject.getString("remarks");
            money=jsonObject.getString("money");
            redPacketId=jsonObject.getString("redPacketId");
        } catch (JSONException e) {
            e.printStackTrace();
        }
        userName.setText(name);
        markText.setText(remark);
        //String receiveState.
        final String finalRedPacketId = redPacketId;
        mBtnFlip.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                if(finalRedPacketId==null){
                    return;
                }
                Map<String,Object> map=new HashMap<String, Object>();
                map.put("redPacketId",finalRedPacketId);
                map.put("messageId",bean.getMessageId());//所抢红包的那个消息的id
                map.put("position",bean.getPosition());
                DefaultEventEntity obj = new DefaultEventEntity(receiveHandler, map);
                RxBus.getDefault().post(obj);
                if (dialog != null && dialog.isShowing()) {
                    dialog.dismiss();
                }

            }
        });
        showPop(bean);
        //flipCardShow();
    }
    private void receivePacketHandle(){

    }


    private void showPop(DialogHelper.DilaogBean bean) {
        if (dialog != null && !dialog.isShowing()) {
            dialog.show();
        }
        /*if (!((Activity) mContext).isDestroyed()
                && bean != null
                && bean.getStatus() == DialogHelper.DilaogBean.STATUS_ROTATE
                && mContainerFlip != null
                && mAnimatorUtil != null) {
            mContainerFlip.setVisibility(View.VISIBLE);
            mAnimatorUtil.cardChange(mContainerFlip, (Activity) mContext);
        }*/
    }

    /*private void flipCardShow() {
        if (!((Activity) mContext).isDestroyed()
                && mContainerFlip != null
                && mAnimatorUtil != null) {
            mContainer.setRotationY(0);
            mAnimatorUtil.cardChange(mContainer, (Activity) mContext);
        }
    }*/

    /*private void flipCardChange() {
        if (!((Activity) mContext).isDestroyed()
                && mContainerFlip != null
                && mAnimatorUtil != null) {
            mAnimatorUtil.flipChange(mContainerFlip, mContainer);
        }
    }*/
}
