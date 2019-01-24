package com.qidu.chat;

import android.content.Context;
import android.content.Intent;

import com.qidu.chat.activity.AddServerActivity;
import com.qidu.chat.activity.LoginActivity;
import com.qidu.chat.activity.ChatMainActivity;

/**
 * utility class for launching Activity.
 */
public class LaunchUtil {

  /**
   * launch ChatMainActivity with proper flags.
   */
  /*public static void showMainActivity(Context context) {
    Intent intent = new Intent(context, ChatMainActivity.class);
    intent.setFlags(Intent.FLAG_ACTIVITY_REORDER_TO_FRONT | Intent.FLAG_ACTIVITY_CLEAR_TOP);
    context.startActivity(intent);
  }*/

  /**
   * launch AddServerActivity with proper flags.
   */
  public static void showAddServerActivity(Context context) {
    Intent intent = new Intent(context, AddServerActivity.class);
    intent.setFlags(Intent.FLAG_ACTIVITY_REORDER_TO_FRONT | Intent.FLAG_ACTIVITY_CLEAR_TOP);
    context.startActivity(intent);
  }

  /**
   * launch ServerConfigActivity with proper flags.
   */
  public static void showLoginActivity(Context context, String hostname) {
    Intent intent = new Intent(context, LoginActivity.class);
    intent.setFlags(Intent.FLAG_ACTIVITY_REORDER_TO_FRONT | Intent.FLAG_ACTIVITY_CLEAR_TOP);
    intent.putExtra(LoginActivity.KEY_HOSTNAME, hostname);
    context.startActivity(intent);
  }
}
