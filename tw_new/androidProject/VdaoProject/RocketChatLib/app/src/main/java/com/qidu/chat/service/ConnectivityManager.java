package com.qidu.chat.service;

import android.content.Context;

/**
 * Connectivity Manager API Factory.
 */
public class ConnectivityManager {
  private static final RealmBasedConnectivityManager IMPL = new RealmBasedConnectivityManager();

  public static ConnectivityManagerApi getInstance(Context appContext) {
    return IMPL.setContext(appContext);
  }

  /*package*/ static ConnectivityManagerInternal getInstanceForInternal(Context appContext) {
    return IMPL.setContext(appContext);
  }
}
