package com.qidu.chat.service.ddp.base;

import android.content.Context;

import com.qidu.chat.service.DDPClientRef;
import com.qidu.chat.service.ddp.AbstractDDPDocEventSubscriber;

import org.json.JSONArray;

import chat.rocket.persistence.realm.RealmHelper;

abstract class AbstractBaseSubscriber extends AbstractDDPDocEventSubscriber {
  protected AbstractBaseSubscriber(Context context, String hostname, RealmHelper realmHelper,
                                   DDPClientRef ddpClientRef) {
    super(context, hostname, realmHelper, ddpClientRef);
  }

  @Override
  protected final JSONArray getSubscriptionParams() {
    return null;
  }

  @Override
  protected final boolean shouldTruncateTableOnInitialize() {
    return false;
  }

  protected abstract String getSubscriptionCallbackName();

  @Override
  protected final boolean isTarget(String callbackName) {
    return getSubscriptionCallbackName().equals(callbackName);
  }
}
