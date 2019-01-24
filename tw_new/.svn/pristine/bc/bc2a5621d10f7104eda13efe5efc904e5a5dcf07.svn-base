package com.qidu.chat.activity;

import java.util.List;

import com.qidu.chat.shared.BaseContract;
import chat.rocket.core.utils.Pair;

public interface MainContract {

  interface View extends BaseContract.View {

    void showHome();

    void showRoom(String hostname, String roomId);

    void showUnreadCount(long roomsCount, int mentionsCount);

    void showAddServerScreen();

    void showLoginScreen();

    void showConnectionError();

    void showConnecting();

    void showConnectionOk();

    void showSignedInServers(List<Pair<String, Pair<String, String>>> serverList);
  }

  interface Presenter extends BaseContract.Presenter<View> {

    void onOpenRoom(String hostname, String roomId);

    void onRetryLogin();

    void bindViewOnly(View view);

    void loadSignedInServers(String hostname);
  }
}
