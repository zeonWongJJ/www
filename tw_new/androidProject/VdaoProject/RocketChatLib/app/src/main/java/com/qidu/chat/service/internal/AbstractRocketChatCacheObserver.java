package com.qidu.chat.service.internal;

import android.content.Context;

import com.hadisatrio.optional.Optional;
import com.qidu.chat.helper.TextUtils;
import com.qidu.chat.service.Registrable;

import chat.rocket.android.log.RCLog;
import io.reactivex.disposables.CompositeDisposable;

import com.qidu.chat.RocketChatCache;

import chat.rocket.persistence.realm.models.ddp.RealmRoom;
import chat.rocket.persistence.realm.RealmHelper;

public abstract class AbstractRocketChatCacheObserver implements Registrable {
  private final Context context;
  private final RealmHelper realmHelper;
  private String roomId;
  private CompositeDisposable compositeDisposable = new CompositeDisposable();

  protected AbstractRocketChatCacheObserver(Context context, RealmHelper realmHelper) {
    this.context = context;
    this.realmHelper = realmHelper;
  }

  private void updateRoomIdWith(String roomId) {
    if (!TextUtils.isEmpty(roomId)) {
      RealmRoom room = realmHelper.executeTransactionForRead(realm ->
          realm.where(RealmRoom.class).equalTo("rid", roomId).findFirst());
      if (room != null) {
        if (this.roomId == null || !this.roomId.equals(roomId)) {
          this.roomId = roomId;
          onRoomIdUpdated(roomId);
        }
        return;
      }
    }

    if (this.roomId != null) {
      this.roomId = null;
      onRoomIdUpdated(null);
    }
  }

  protected abstract void onRoomIdUpdated(String roomId);

  @Override
  public final void register() {
    compositeDisposable.add(
        new RocketChatCache(context)
            .getSelectedRoomIdPublisher()
            .map(Optional::get)
            .subscribe(this::updateRoomIdWith, RCLog::e)
    );
  }

  @Override
  public final void unregister() {
    compositeDisposable.clear();
  }
}
