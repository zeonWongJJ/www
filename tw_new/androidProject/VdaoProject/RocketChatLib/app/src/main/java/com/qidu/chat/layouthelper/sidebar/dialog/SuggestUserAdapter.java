package com.qidu.chat.layouthelper.sidebar.dialog;

import android.content.Context;
import android.view.View;

import com.qidu.chat.renderer.UserRenderer;

import java.util.Iterator;
import java.util.List;
import com.qidu.chat.R;
import chat.rocket.android.widget.AbsoluteUrl;
import chat.rocket.persistence.realm.models.ddp.RealmUser;
import chat.rocket.persistence.realm.RealmAutoCompleteAdapter;
import com.qidu.chat.renderer.UserRenderer;

/**
 * adapter to suggest user names.
 */
public class SuggestUserAdapter extends RealmAutoCompleteAdapter<RealmUser> {
  private final AbsoluteUrl absoluteUrl;
  private final String hostname;

  public SuggestUserAdapter(Context context, AbsoluteUrl absoluteUrl, String hostname) {
    super(context, R.layout.listitem_room_user, R.id.room_user_name);
    this.absoluteUrl = absoluteUrl;
    this.hostname = hostname;
  }

  @Override
  protected void onBindItemView(View itemView, RealmUser user) {
    UserRenderer userRenderer = new UserRenderer(user.asUser());
    userRenderer.showStatusColor(itemView.findViewById(R.id.room_user_status));
    userRenderer.showAvatar(itemView.findViewById(R.id.room_user_avatar), hostname);
  }

  @Override
  protected void filterList(List<RealmUser> users, String text) {
    Iterator<RealmUser> itUsers = users.iterator();
    final String prefix = text.toLowerCase();
    while (itUsers.hasNext()) {
      RealmUser user = itUsers.next();
      if (!user.getUsername().toLowerCase().startsWith(prefix)) {
        itUsers.remove();
      }
    }
  }

  @Override
  protected String getStringForSelectedItem(RealmUser user) {
    return user.getUsername();
  }
}
