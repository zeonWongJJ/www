package com.qidu.chat.fragment.server_config;

import com.qidu.chat.api.MethodCallHelper;
import com.qidu.chat.shared.BasePresenter;

public class TwoStepAuthPresenter extends BasePresenter<TwoStepAuthContract.View>
    implements TwoStepAuthContract.Presenter {

  private final MethodCallHelper methodCallHelper;
  private final String usernameOrEmail;
  private final String password;

  public TwoStepAuthPresenter(MethodCallHelper methodCallHelper, String usernameOrEmail,
                              String password) {
    this.methodCallHelper = methodCallHelper;
    this.usernameOrEmail = usernameOrEmail;
    this.password = password;
  }

  @Override
  public void onCode(String twoStepAuthCode) {
    view.showLoading();

    methodCallHelper.twoStepCodeLogin(usernameOrEmail, password, twoStepAuthCode)
        .continueWith(task -> {
          if (task.isFaulted()) {
            view.hideLoading();

            view.showError(task.getError().getMessage());
          }
          return null;
        });
  }
}
