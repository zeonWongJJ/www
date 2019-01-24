package com.qidu.chat.fragment.server_config;

import com.qidu.chat.shared.BaseContract;

public interface RetryLoginContract {

  interface View extends BaseContract.View {

    void showRetry(String token);

    void showError(String message);

    void showLoader();

    void hideLoader();
  }

  interface Presenter extends BaseContract.Presenter<View> {

    void onLogin(String token);
  }
}
