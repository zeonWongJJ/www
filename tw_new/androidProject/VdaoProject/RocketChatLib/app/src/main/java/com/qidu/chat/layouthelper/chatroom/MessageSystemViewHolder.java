package com.qidu.chat.layouthelper.chatroom;

import android.support.v4.app.FragmentActivity;
import android.view.View;
import android.widget.TextView;

import com.qidu.chat.R;
import com.qidu.chat.renderer.MessageRenderer;
import chat.rocket.android.widget.AbsoluteUrl;

/**
 * ViewData holder of NORMAL chat message.
 */
public class MessageSystemViewHolder extends AbstractMessageViewHolder {
  private final TextView body;
  private FragmentActivity activity;
  /**
   * constructor WITH hostname.
   */
  public MessageSystemViewHolder(FragmentActivity activity,View itemView, AbsoluteUrl absoluteUrl, String hostname) {
    super(itemView, absoluteUrl, hostname);
    this.activity=activity;
    body = itemView.findViewById(R.id.message_body);
  }

  @Override
  protected void bindMessage(PairedMessage pairedMessage,int position, boolean autoloadImages) {
    MessageRenderer messageRenderer = new MessageRenderer(activity,pairedMessage.target, autoloadImages);
    messageRenderer.showAvatar(avatar, hostname);
    messageRenderer.showUsername(username, subUsername);
    messageRenderer.showTimestampOrMessageState(timestamp);
    if (pairedMessage.target != null) {
      body.setText(MessageType.parse(pairedMessage.target.getType())
          .getString(body.getContext(), pairedMessage.target));
    }
  }
}
