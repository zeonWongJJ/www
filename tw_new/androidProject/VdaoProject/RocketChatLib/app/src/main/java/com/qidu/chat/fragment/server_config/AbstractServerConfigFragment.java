package com.qidu.chat.fragment.server_config;

import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;

import com.qidu.chat.helper.TextUtils;

import com.qidu.chat.R;
import com.qidu.chat.fragment.AbstractFragment;

abstract class AbstractServerConfigFragment extends AbstractFragment {
  public static final String KEY_HOSTNAME = "hostname";

  protected String hostname;

  @Override
  public void onCreate(@Nullable Bundle savedInstanceState) {
    super.onCreate(savedInstanceState);

    Bundle args = getArguments();
    if (args == null) {
      finish();
      return;
    }

    hostname = args.getString(KEY_HOSTNAME);
    if (TextUtils.isEmpty(hostname)) {
      finish();
    }
  }

  protected void showFragment(Fragment fragment) {
    getFragmentManager().beginTransaction()
        .add(R.id.content, fragment)
        .commit();
  }

  protected void showFragmentWithBackStack(Fragment fragment) {
    getFragmentManager().beginTransaction()
        .add(R.id.content, fragment)
        .addToBackStack(null)
        .commit();
  }
}
