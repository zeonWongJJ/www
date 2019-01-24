package com.qidu.chat;

import android.os.Build;
import android.support.multidex.MultiDexApplication;
import android.support.v7.app.AppCompatDelegate;

import com.google.firebase.FirebaseApp;
import com.gzqx.common.base.BaseApplication;

import com.qidu.chat.service.ConnectivityManager;

import java.util.List;
import chat.rocket.persistence.realm.RealmStore;
import chat.rocket.core.models.ServerInfo;
import chat.rocket.persistence.realm.RocketChatPersistenceRealm;

/**
 * Customized Application-class for Rocket.Chat
 */
public class RocketChatApplication extends BaseApplication {
  private static RocketChatApplication instance;

  public static RocketChatApplication getInstance() {
    return instance;
  }
  @Override
  public void onCreate() {
    super.onCreate();
    instance=this;
    //Fabric.with(this, new Crashlytics());
    //FirebaseApp.initializeApp(this);
    RocketChatPersistenceRealm.init(this);

    List<ServerInfo> serverInfoList = ConnectivityManager.getInstance(this).getServerList();
    for (ServerInfo serverInfo : serverInfoList) {
      RealmStore.put(serverInfo.getHostname());
    }

    //RocketChatWidgets.initialize(this, OkHttpHelper.INSTANCE.getClientForDownloadFile(this));

    if (Build.VERSION.SDK_INT < Build.VERSION_CODES.LOLLIPOP) {
      AppCompatDelegate.setCompatVectorFromResourcesEnabled(true);
    }
  }
}