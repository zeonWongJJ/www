package com.qidu.chat.layouthelper.chatroom;

import android.content.Context;
import android.content.SharedPreferences;
import android.support.v4.app.FragmentActivity;
import android.support.v4.util.Pair;
import android.util.Log;
import android.view.View;
import android.widget.LinearLayout;
import android.widget.TextView;

import org.json.JSONException;
import org.json.JSONObject;

import com.qidu.chat.BackgroundLooper;
import com.qidu.chat.R;
import com.qidu.chat.helper.Logger;
import com.qidu.chat.renderer.MessageRenderer;
import chat.rocket.android.widget.AbsoluteUrl;
import chat.rocket.android.widget.message.RocketChatMessageAttachmentsLayout;
import chat.rocket.android.widget.message.RocketChatMessageLayout;
import chat.rocket.android.widget.message.RocketChatMessageUrlsLayout;
import chat.rocket.core.models.Message;
import chat.rocket.core.utils.CommonKey;
import chat.rocket.persistence.realm.repositories.RealmMessageRepository;
import io.reactivex.Single;
import io.reactivex.android.schedulers.AndroidSchedulers;
import io.reactivex.disposables.Disposable;
import io.reactivex.functions.Consumer;

/**
 * ViewData holder of NORMAL chat message.
 */
public class MessageNormalViewHolder extends AbstractMessageViewHolder {
  private final RocketChatMessageLayout body;
  private final RocketChatMessageUrlsLayout urls;
  private final RocketChatMessageAttachmentsLayout attachments;
  private final LinearLayout bodyUrlsVontainer;
    private boolean isSelf;
  private FragmentActivity activity;
  private TextView botTip;
  private View itemContainer;

  private View.OnClickListener audioClickListener;

  /**
   * constructor WITH hostname.
   */
  public MessageNormalViewHolder(FragmentActivity activity, View itemView, AbsoluteUrl absoluteUrl, String hostname, boolean isSelf, View.OnClickListener audioClickListener) {//isSelf用于区别自己还是别人的标记
    super(itemView, absoluteUrl, hostname);
    this.audioClickListener=audioClickListener;
    this.activity=activity;
     this.isSelf=isSelf;
    body = itemView.findViewById(R.id.message_body);
    urls = itemView.findViewById(R.id.message_urls);
    attachments = itemView.findViewById(R.id.message_attachments);
    botTip=itemView.findViewById(R.id.bot_tip);
    bodyUrlsVontainer=itemView.findViewById(R.id.container);
    itemContainer=itemView.findViewById(R.id.item_container);
  }

  @Override
  protected void bindMessage(PairedMessage pairedMessage, int position,boolean autoloadImages) {

    if(pairedMessage.target.getMessage().startsWith(":SHB:")){
      botTip.setVisibility(View.GONE);
      itemContainer.setVisibility(View.GONE);
      SharedPreferences sp = activity.getSharedPreferences(CommonKey.KEY_LOGIN_USER_ID, Context.MODE_PRIVATE);
      String localUserId = sp.getString("user_id", null);

      final String response=pairedMessage.target.getMessage().replace(":SHB:","");
      String userName="";
      String userId=null;
      try {
        JSONObject jsonObject=new JSONObject(response);
        userName=jsonObject.getString("userName");
        userId=jsonObject.getString("userId");
      } catch (JSONException e) {
        e.printStackTrace();
      }
        if(localUserId.equals(userId)){
          botTip.setText("你领取了自己的红包");
        }else {
          botTip.setText(userName+"领取了红包");
        }
    }else if(pairedMessage.target.getMessage().startsWith("bot:SHB:")){//成功收到一个红包之后，在此更新点击的那个红包是否可点的状态
      botTip.setVisibility(View.VISIBLE);
      itemContainer.setVisibility(View.GONE);
      SharedPreferences sp = activity.getSharedPreferences(CommonKey.KEY_LOGIN_USER_ID, Context.MODE_PRIVATE);
      String localUserId = sp.getString("user_id", null);
      final String response=pairedMessage.target.getMessage().replace("bot:SHB:","");
      String userName="";
      String userId=null;
      try {
        JSONObject jsonObject=new JSONObject(response);
        userName=jsonObject.getString("userName");
        userId=jsonObject.getString("userId");
      } catch (JSONException e) {
        e.printStackTrace();
      }
      if(localUserId.equals(userId)){
        botTip.setText("你领取了自己的红包");
      }else {
        botTip.setText(userName+"领取了红包");
      }
    }else {
      botTip.setVisibility(View.GONE);
      itemContainer.setVisibility(View.VISIBLE);
      LinearLayout parent= (LinearLayout) body.getParent();
      if(isSelf){
        parent.setBackground(activity.getResources().getDrawable(R.drawable.message_right));
      }else {
        parent.setBackground(activity.getResources().getDrawable(R.drawable.message_left));
      }
      MessageRenderer messageRenderer = new MessageRenderer(this.activity, pairedMessage.target, autoloadImages);
      messageRenderer.showAvatar(avatar, hostname);
      messageRenderer.showUsername(username, subUsername);
      messageRenderer.showTimestampOrMessageState(timestamp);
      messageRenderer.showBody(body,position, isSelf,bodyUrlsVontainer);
      messageRenderer.showUrl(urls, isSelf);
      messageRenderer.showAttachment(attachments, absoluteUrl, isSelf, bodyUrlsVontainer,audioClickListener);
    }
  }
}
