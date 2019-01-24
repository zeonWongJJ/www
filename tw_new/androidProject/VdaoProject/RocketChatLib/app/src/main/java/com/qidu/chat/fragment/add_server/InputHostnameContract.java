package com.qidu.chat.fragment.add_server;

import com.qidu.chat.shared.BaseContract;

public interface InputHostnameContract {

  interface View extends BaseContract.View {
    void showLoader();

    void hideLoader();

    void showInvalidServerError();

    void showConnectionError();

    void showHome();
  }

  interface Presenter extends BaseContract.Presenter<View> {

    void connectTo(String hostname);
  }

}
