package chat.rocket.android.widget.message;

import android.annotation.TargetApi;
import android.content.Context;
import android.content.SharedPreferences;
import android.os.Build;
import android.support.v4.app.FragmentActivity;
import android.text.TextUtils;
import android.util.AttributeSet;
import android.util.Log;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.bumptech.glide.Glide;
import com.emojione.Emojione;
import com.luck.picture.lib.rxbus2.RxBus;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

import bean.DefaultEventEntity;
import chat.rocket.android.widget.R;
import chat.rocket.android.widget.helper.InlineHightlighter;
import chat.rocket.android.widget.helper.Linkify;
import chat.rocket.android.widget.helper.MarkDown;
import chat.rocket.core.models.Message;
import chat.rocket.core.utils.CommonKey;
import common.Constants;
import redpacket.lib.DialogController;
import redpacket.lib.DialogHelper;

/**
 */
public class RocketChatMessageLayout extends LinearLayout {
  private LayoutInflater inflater;

  public RocketChatMessageLayout(Context context) {
    super(context);
    initialize(context, null);
  }

  public RocketChatMessageLayout(Context context, AttributeSet attrs) {
    super(context, attrs);
    initialize(context, attrs);
  }

  public RocketChatMessageLayout(Context context, AttributeSet attrs, int defStyleAttr) {
    super(context, attrs, defStyleAttr);
    initialize(context, attrs);
  }

  @TargetApi(Build.VERSION_CODES.LOLLIPOP)
  public RocketChatMessageLayout(Context context, AttributeSet attrs, int defStyleAttr,
                                 int defStyleRes) {
    super(context, attrs, defStyleAttr, defStyleRes);
    initialize(context, attrs);
  }

  private void initialize(Context context, AttributeSet attrs) {
    inflater = LayoutInflater.from(context);
    setOrientation(VERTICAL);
  }

  private FragmentActivity activity;

  public void setText(final FragmentActivity activity, final Message message, final int position, boolean isSelf) {
    String messageBody=message.getMessage();
    this.activity=activity;
    removeAllViews();
    //区别是否是bot的，如果是bot就不显示
    //根据消息id即红包id 判断红包状态   加载历史消息 拿msgid查红包信息

  //bot :FHB:


    if(messageBody.startsWith("bot:FHB:")){//红包标记  :FHB:
      LinearLayout parent= (LinearLayout) this.getParent();
      parent.setBackground(null);
      final String response=messageBody.replace("bot:FHB:","");
      String remark="";
      String receiveState="";
      try {
        JSONObject jsonObject=new JSONObject(response);
        remark=jsonObject.getString("remarks");
        receiveState=jsonObject.getString("receiveState");
        Log.i("bbbbb","receiveState-->"+receiveState+"=======");
      } catch (JSONException e) {
        e.printStackTrace();
      }
      View view = inflater.inflate(R.layout.message_red_packet_item, this, false);
      TextView textView=view.findViewById(R.id.remark);
      textView.setText(remark);
      if(isSelf){
        if(receiveState.equals("no")){
          view.setBackgroundResource(R.drawable.show_receive_red_packet_normal_right);
        }else {
          view.setBackgroundResource(R.drawable.icon_red_packet_unpress);
        }
      }else {
        if(receiveState.equals("no")){
          view.setBackgroundResource(R.drawable.show_receive_red_packet_normal);
        }else {
          view.setBackgroundResource(R.drawable.icon_red_packet_unpress);
        }
      }
      view.setOnClickListener(new OnClickListener() {
        @Override
        public void onClick(View view) {
          Map<String,Object> map=new HashMap<>();
          map.put("response",response);
          map.put("messageId",message.getId());
          map.put("position",position);
          DefaultEventEntity obj = new DefaultEventEntity(Constants.RED_PACKET_CLICK_DIALOG,map);
          RxBus.getDefault().post(obj);
        }
      });
      addView(view);
    }else {
      if (messageBody.contains("```")) {
        boolean highlight = false;
        for (final String chunk : TextUtils.split(messageBody.replace("\r\n", "\n"), "```")) {
          final String trimmedChunk = chunk.replaceFirst("^\n", "").replaceFirst("\n$", "");
          if (highlight) {
            appendHighlightTextView(trimmedChunk, isSelf);
          } else if (trimmedChunk.length() > 0) {
            appendTextView(trimmedChunk, isSelf);
          }
          highlight = !highlight;
        }
      } else {
        appendTextView(messageBody, isSelf);
      }
    }
  }

  private void appendHighlightTextView(String text,boolean isSelf) {
    TextView textView = (TextView) inflater.inflate(R.layout.message_body_highlight, this, false);
    /*if(isSelf){
      textView.setGravity(Gravity.RIGHT);
    }*/
    textView.setText(text);

    Linkify.markup(textView);

    addView(textView);
  }

  private void appendTextView(String text,boolean isSelf) {
    if (!TextUtils.isEmpty(text)) {

      View view=inflater.inflate(R.layout.message_body, this, false);
      addView(view);
      ImageView imageView=view.findViewById(R.id.image_view);
      TextView textView = (TextView)view.findViewById(R.id.text);

      if(Emojione.isCustomEmoji(view,text)){
        LinearLayout parent= (LinearLayout) this.getParent();
        parent.setBackground(null);
        textView.setVisibility(GONE);
        imageView.setVisibility(VISIBLE);
        Glide.with(activity).load(Emojione.shortnameToUnicode(textView,text, false)).into(imageView);

      }else {

        String mtext=Emojione.shortnameToUnicode(textView,text, false);
        textView.setText(mtext);
        MarkDown.apply(textView);
        Linkify.markup(textView);
        InlineHightlighter.highlight(textView);

      }
    }
  }
}
