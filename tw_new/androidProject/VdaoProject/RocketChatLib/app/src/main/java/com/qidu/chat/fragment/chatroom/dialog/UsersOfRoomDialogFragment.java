package com.qidu.chat.fragment.chatroom.dialog;

import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.annotation.Nullable;
import android.support.v7.widget.GridLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.View;
import android.widget.TextView;
import com.hadisatrio.optional.Optional;
import com.qidu.chat.helper.AbsoluteUrlHelper;
import com.qidu.chat.helper.LogIfError;
import com.qidu.chat.helper.Logger;
import com.qidu.chat.layouthelper.chatroom.dialog.RoomUserAdapter;
import com.qidu.chat.service.ConnectivityManager;

import io.reactivex.android.schedulers.AndroidSchedulers;
import io.reactivex.disposables.CompositeDisposable;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;
import com.qidu.chat.BackgroundLooper;
import com.qidu.chat.R;
import com.qidu.chat.fragment.chatroom.RocketChatAbsoluteUrl;

import chat.rocket.android.log.RCLog;
import chat.rocket.core.SyncState;
import chat.rocket.core.interactors.SessionInteractor;
import chat.rocket.persistence.realm.models.internal.GetUsersOfRoomsProcedure;
import chat.rocket.persistence.realm.RealmObjectObserver;
import chat.rocket.persistence.realm.repositories.RealmServerInfoRepository;
import chat.rocket.persistence.realm.repositories.RealmSessionRepository;
import chat.rocket.persistence.realm.repositories.RealmUserRepository;

/**
 * Dialog to show members in a room.
 * 房间成员
 */
public class UsersOfRoomDialogFragment extends AbstractChatRoomDialogFragment {

  private String hostname;
  private RealmObjectObserver<GetUsersOfRoomsProcedure> procedureObserver;
  private int previousSyncState;
  private RoomUserAdapter adapter;

  private CompositeDisposable compositeDisposable = new CompositeDisposable();

  public UsersOfRoomDialogFragment() {
  }

  /**
   * create UsersOfRoomDialogFragment with required parameters.
   */
  public static UsersOfRoomDialogFragment create(String roomId, String hostname) {
    Bundle args = new Bundle();
    args.putString("hostname", hostname);
    args.putString("roomId", roomId);

    UsersOfRoomDialogFragment fragment = new UsersOfRoomDialogFragment();
    fragment.setArguments(args);

    return fragment;
  }

  @Override
  public void onCreate(@Nullable Bundle savedInstanceState) {
    super.onCreate(savedInstanceState);

    procedureObserver = realmHelper
        .createObjectObserver(realm ->
            realm.where(GetUsersOfRoomsProcedure.class).equalTo("roomId", roomId))
        .setOnUpdateListener(this::onUpdateGetUsersOfRoomProcedure);
    previousSyncState = SyncState.NOT_SYNCED;

    if (savedInstanceState == null) {
      requestGetUsersOfRoom();
    }
  }

  @Override
  protected void handleArgs(@NonNull Bundle args) {
    super.handleArgs(args);
    hostname = args.getString("hostname");
  }

  @Override
  protected int getLayout() {
    return R.layout.dialog_users_of_room;
  }

  @Override
  protected void onSetupDialog() {
    RecyclerView recyclerView = (RecyclerView) getDialog().findViewById(R.id.recyclerview);
    recyclerView.setLayoutManager(new GridLayoutManager(getContext(), 2));
    adapter=new RoomUserAdapter(getContext(), realmHelper/*, rocketChatAbsoluteUrlOptional.get()*/, hostname);
    recyclerView.setAdapter(adapter);

    AbsoluteUrlHelper absoluteUrlHelper = new AbsoluteUrlHelper(
        hostname,
        new RealmServerInfoRepository(),
        new RealmUserRepository(hostname),
        new SessionInteractor(new RealmSessionRepository(hostname))
    );

    compositeDisposable.add(
        absoluteUrlHelper.getRocketChatAbsoluteUrl()
            .subscribeOn(AndroidSchedulers.from(BackgroundLooper.get()))
            .observeOn(AndroidSchedulers.mainThread())
            .subscribe(
                this::setupView,
                Logger::report
            )
    );
  }

  private void setupView(Optional<RocketChatAbsoluteUrl> rocketChatAbsoluteUrlOptional) {
    compositeDisposable.clear();

    if (!rocketChatAbsoluteUrlOptional.isPresent()) {
      return;
    }

    /*RecyclerView recyclerView = (RecyclerView) getDialog().findViewById(R.id.recyclerview);
    recyclerView.setLayoutManager(new GridLayoutManager(getContext(), 2));
    recyclerView.setAdapter(
        new RoomUserAdapter(getContext(), realmHelper*//*, rocketChatAbsoluteUrlOptional.get()*//*, hostname));*/
  }

  private void requestGetUsersOfRoom() {
    realmHelper.executeTransaction(realm -> {
      realm.createOrUpdateObjectFromJson(GetUsersOfRoomsProcedure.class, new JSONObject()
          .put("roomId", roomId)
          .put("syncstate", SyncState.NOT_SYNCED)
          .put("showAll", true));
      return null;
    }).onSuccessTask(task -> {
      ConnectivityManager.getInstance(getContext().getApplicationContext())
          .keepAliveServer();
      return task;
    }).continueWith(new LogIfError());
  }

  @Override
  public void onResume() {
    super.onResume();
    procedureObserver.sub();
  }

  @Override
  public void onPause() {
    procedureObserver.unsub();
    super.onPause();
  }

  private void onUpdateGetUsersOfRoomProcedure(GetUsersOfRoomsProcedure procedure) {
    if (procedure == null) {
      return;
    }

    int syncState = procedure.getSyncState();
    if (previousSyncState != syncState) {
      onSyncStateUpdated(syncState);
      previousSyncState = syncState;
    }

    if (syncState == SyncState.SYNCED) {
      onRenderTotalCount(procedure.getTotal());

      try {
        JSONArray array = new JSONArray(procedure.getRecords());
        ArrayList<String> users = new ArrayList<>();
        for (int i = 0; i < array.length(); i++) {
          Object userObject = array.get(i);
          if (userObject instanceof JSONObject) {
            JSONObject user = (JSONObject) userObject;
            users.add(user.getString("username"));//使用不同邮箱注册时候，输入存在过的username,新的账号里面就没有username字段，而是放在了name字段
          } else {
            users.add((String) userObject);
          }
        }
        onRenderUsers(users);
      } catch (JSONException exception) {
        RCLog.e(exception);
      }
    }
  }

  /**
   * called only if prevSyncstate != newSyncstate.
   */
  private void onSyncStateUpdated(int newSyncState) {
    boolean show = newSyncState == SyncState.NOT_SYNCED || newSyncState == SyncState.SYNCING;
    getDialog().findViewById(R.id.waiting).setVisibility(show ? View.VISIBLE : View.GONE);
  }

  /**
   * called only if syncstate = SYNCED.
   */
  private void onRenderTotalCount(long total) {
    TextView userCount = (TextView) getDialog().findViewById(R.id.room_user_count);
    userCount.setText(getResources().getQuantityString(R.plurals.fmt_room_user_count, (int) total, total));
  }

  /**
   * called only if syncstate = SYNCED.
   */
  private void onRenderUsers(List<String> usernames) {
    /*RecyclerView recyclerView = (RecyclerView) getDialog().findViewById(R.id.recyclerview);
    if (recyclerView != null && recyclerView.getAdapter() instanceof RoomUserAdapter) {
      ((RoomUserAdapter) recyclerView.getAdapter()).setUsernames(usernames);
      recyclerView.requestLayout();
    }*/
    adapter.setUsernames(usernames);
  }
}
