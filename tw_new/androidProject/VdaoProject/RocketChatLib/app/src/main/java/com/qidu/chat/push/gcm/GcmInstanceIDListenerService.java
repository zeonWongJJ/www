package com.qidu.chat.push.gcm;

/*import android.util.Log;

import com.google.android.gms.iid.InstanceIDListenerService;
import com.qidu.chat.helper.GcmPushSettingHelper;
import com.qidu.chat.service.ConnectivityManager;

import java.util.List;

import chat.rocket.persistence.realm.models.ddp.RealmPublicSetting;
import chat.rocket.persistence.realm.models.internal.GcmPushRegistration;
import chat.rocket.persistence.realm.RealmHelper;
import chat.rocket.persistence.realm.RealmStore;
import chat.rocket.core.models.ServerInfo;*/

/*
public class GcmInstanceIDListenerService extends InstanceIDListenerService {

  @Override
  public void onTokenRefresh() {
    Log.i("GcmInstance","onTokenRefresh");
    List<ServerInfo> serverInfoList = ConnectivityManager.getInstance(getApplicationContext())
        .getServerList();
    for (ServerInfo serverInfo : serverInfoList) {
      RealmHelper realmHelper = RealmStore.get(serverInfo.getHostname());
      if (realmHelper != null) {
        updateGcmToken(realmHelper);
      }
    }
  }

  private void updateGcmToken(RealmHelper realmHelper) {
    final List<RealmPublicSetting> results = realmHelper.executeTransactionForReadResults(
        GcmPushSettingHelper::queryForGcmPushEnabled);
    final boolean gcmPushEnabled = GcmPushSettingHelper.isGcmPushEnabled(results);

    if (gcmPushEnabled) {
      realmHelper.executeTransaction(realm ->
          GcmPushRegistration.updateGcmPushEnabled(realm, gcmPushEnabled));
    }
  }
}*/
