package com.qidu.chat.fragment.server_config;

import android.support.annotation.NonNull;

import com.hadisatrio.optional.Optional;
import com.qidu.chat.api.MethodCallHelper;
import com.qidu.chat.helper.Logger;
import com.qidu.chat.helper.TextUtils;

import io.reactivex.android.schedulers.AndroidSchedulers;

import bolts.Task;
import com.qidu.chat.BackgroundLooper;
import com.qidu.chat.api.TwoStepAuthException;
import com.qidu.chat.shared.BasePresenter;
import chat.rocket.core.PublicSettingsConstants;
import chat.rocket.core.models.PublicSetting;
import chat.rocket.core.repositories.LoginServiceConfigurationRepository;
import chat.rocket.core.repositories.PublicSettingRepository;

public class LoginPresenter extends BasePresenter<LoginContract.View>
    implements LoginContract.Presenter {

  private final LoginServiceConfigurationRepository loginServiceConfigurationRepository;
  private final PublicSettingRepository publicSettingRepository;
  private final MethodCallHelper methodCallHelper;

  public LoginPresenter(LoginServiceConfigurationRepository loginServiceConfigurationRepository,
                        PublicSettingRepository publicSettingRepository,
                        MethodCallHelper methodCallHelper) {
    this.loginServiceConfigurationRepository = loginServiceConfigurationRepository;
    this.publicSettingRepository = publicSettingRepository;
    this.methodCallHelper = methodCallHelper;
  }

  @Override
  public void bindView(@NonNull LoginContract.View view) {
    super.bindView(view);

    getLoginServices();
  }

  @Override
  public void login(String username, String password) {
    if (TextUtils.isEmpty(username) || TextUtils.isEmpty(password)) {
      return;
    }

    view.showLoader();

    addSubscription(
        publicSettingRepository.getById(PublicSettingsConstants.LDAP.ENABLE)
            .subscribeOn(AndroidSchedulers.from(BackgroundLooper.get()))
            .observeOn(AndroidSchedulers.mainThread())
            .subscribe(
                publicSettingOptional -> doLogin(username, password, publicSettingOptional),
                Logger::report
            )
    );
  }

  private void getLoginServices() {
    addSubscription(
        loginServiceConfigurationRepository.getAll()
            .subscribeOn(AndroidSchedulers.from(BackgroundLooper.get()))
            .observeOn(AndroidSchedulers.mainThread())
            .subscribe(
                loginServiceConfigurations -> view.showLoginServices(loginServiceConfigurations),
                Logger::report
            )
    );
  }

  private void doLogin(String username, String password, Optional<PublicSetting> optional) {
    call(username, password, optional)
        .continueWith(task -> {
          if (task.isFaulted()) {
            view.hideLoader();

            final Exception error = task.getError();

            if (error instanceof TwoStepAuthException) {
              view.showTwoStepAuth();
            } else {
              view.showError(error.getMessage());
            }
          }
          return null;
        });
  }

  private Task<Void> call(String username, String password, Optional<PublicSetting> optional) {
    if (optional.isPresent() && optional.get().getValueAsBoolean()) {
      return methodCallHelper.loginWithLdap(username, password);
    }

    return methodCallHelper.loginWithEmail(username, password);
  }
}
