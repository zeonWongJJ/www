package com.qidu.chat.fragment.server_config;

import com.qidu.chat.shared.BaseContract;

public interface TwoStepAuthContract {

  interface View extends BaseContract.View {

    void showLoading();

    void hideLoading();

    void showError(String message);
  }

  interface Presenter extends BaseContract.Presenter<View> {

    void onCode(String twoStepAuthCode);
  }
}
