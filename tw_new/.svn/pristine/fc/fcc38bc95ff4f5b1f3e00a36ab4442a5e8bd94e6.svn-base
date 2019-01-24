package com.qidu.chat.activity;

import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.design.widget.Snackbar;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.FrameLayout;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.bumptech.glide.Glide;
import com.bumptech.glide.Priority;
import com.bumptech.glide.request.RequestOptions;
import com.qidu.chat.RocketChatCache;
import com.qidu.chat.api.MethodCallHelper;
import com.qidu.chat.service.ConnectivityManager;

import java.util.List;

import com.qidu.chat.LaunchUtil;
import com.qidu.chat.R;

import com.qidu.chat.fragment.sidebar.SidebarMainFragment;

import chat.rocket.android.widget.RoomToolbar;
import chat.rocket.core.interactors.CanCreateRoomInteractor;
import chat.rocket.core.interactors.RoomInteractor;
import chat.rocket.core.interactors.SessionInteractor;
import chat.rocket.core.repositories.PublicSettingRepository;
import chat.rocket.core.utils.Pair;
import chat.rocket.persistence.realm.repositories.RealmPublicSettingRepository;
import chat.rocket.persistence.realm.repositories.RealmRoomRepository;
import chat.rocket.persistence.realm.repositories.RealmSessionRepository;
import chat.rocket.persistence.realm.repositories.RealmUserRepository;
import common.Constants;
import common.GlideRoundTransform;
import hugo.weaving.DebugLog;
import me.leolin.shortcutbadger.ShortcutBadger;

/**
 * Entry-point for Rocket.Chat.Android application.
 */
public class ChatMainActivity extends AbstractAuthedActivity implements MainContract.View {
  /*private RequestOptions options = new RequestOptions()
          .centerCrop()
          .placeholder(R.mipmap.ic_launcher)
          .error(R.mipmap.ic_launcher)
          .priority(Priority.NORMAL)
          .transform(new GlideRoundTransform());*/
  //private RoomToolbar toolbar;
  //private StatusTicker statusTicker;
  //private SlidingPaneLayout pane;
  private MainContract.Presenter presenter;


  private BroadcastReceiver broadcastReceiver=new BroadcastReceiver() {
    @Override
    public void onReceive(Context context, Intent intent) {
      String action=intent.getAction();
      if(action.equals(Constants.NET_WORK_STATUS_CHANGE)){
        Toast.makeText(ChatMainActivity.this,"连接上了",Toast.LENGTH_SHORT).show();
        onResume();
        //Toast.makeText(ChatMainActivity.this,"onResume",Toast.LENGTH_SHORT).show();
      }
    }
  };
  @Override
  protected int getLayoutContainerForFragment() {
    return R.id.activity_main_container;
  }

  @Override
  protected void onDestroy() {
    super.onDestroy();
    unregisterReceiver(broadcastReceiver);
  }

  @Override
  protected void onCreate(@Nullable Bundle savedInstanceState) {
    super.onCreate(savedInstanceState);
    setContentView(R.layout.activity_main_chat);
    IntentFilter intentFilter=new IntentFilter();
    intentFilter.addAction(Constants.NET_WORK_STATUS_CHANGE);
    registerReceiver(broadcastReceiver,intentFilter);
    /*toolbar = (RoomToolbar) findViewById(R.id.activity_main_toolbar);
    toolbar.setTitle("联系人");*/
    //statusTicker = new StatusTicker();
    //pane = (SlidingPaneLayout) findViewById(R.id.sliding_pane);
    //zsetupToolbar();

  }

  @Override
  protected void onResume() {
    super.onResume();
    if (hostname == null || presenter == null) {
      hostname = new RocketChatCache(getApplicationContext()).getSelectedServerHostname();
      if (hostname == null) {
        showAddServerScreen();
      } else {
        onHostnameUpdated();
      }
    } else {
      presenter.bindViewOnly(this);
      presenter.loadSignedInServers(hostname);
    }
  }

  @Override
  protected void onPause() {
    if (presenter != null) {
      presenter.release();
    }

    super.onPause();
  }

  /*private void showAddServerActivity() {
    Intent intent = new Intent(this, AddServerActivity.class);
    intent.putExtra(EXTRA_FINISH_ON_BACK_PRESS, true);
    startActivity(intent);
  }*/



  @DebugLog
  @Override
  protected void onHostnameUpdated() {
    super.onHostnameUpdated();

    if (presenter != null) {
      presenter.release();
    }

    RoomInteractor roomInteractor = new RoomInteractor(new RealmRoomRepository(hostname));

    CanCreateRoomInteractor createRoomInteractor = new CanCreateRoomInteractor(
        new RealmUserRepository(hostname),
        new SessionInteractor(new RealmSessionRepository(hostname))
    );

    SessionInteractor sessionInteractor = new SessionInteractor(
        new RealmSessionRepository(hostname)
    );

    PublicSettingRepository publicSettingRepository = new RealmPublicSettingRepository(hostname);

    presenter = new MainPresenter(
        roomInteractor,
        createRoomInteractor,
        sessionInteractor,
        new MethodCallHelper(this, hostname),
        ConnectivityManager.getInstance(getApplicationContext()),
        new RocketChatCache(this),
        publicSettingRepository
    );

    updateSidebarMainFragment();

    presenter.bindView(this);
    presenter.loadSignedInServers(hostname);
  }

  protected void updateSidebarMainFragment() {
    //closeSidebarIfNeeded();
    getSupportFragmentManager().beginTransaction()
        .replace(getLayoutContainerForFragment(), SidebarMainFragment.create(hostname))
        .commit();

  }

  @Override
  protected void onRoomIdUpdated() {
    super.onRoomIdUpdated();
    //打开选中room
    presenter.onOpenRoom(hostname, roomId);
  }

  @Override
  protected boolean onBackPress() {
    return /*closeSidebarIfNeeded() || */super.onBackPress();
  }

  @Override
  public void showHome() {
    //showFragment(new HomeFragment());
    //showFragment(SidebarMainFragment.create(hostname));

  }

  @Override
  public void showRoom(String hostname, String roomId) {
    /*showFragment(RoomFragment.create(hostname, roomId));
    closeSidebarIfNeeded();
    KeyboardHelper.hideSoftKeyboard(this);*/
    Intent intent=new Intent(this,ChatRoomActivity.class);
    intent.putExtra("hostname",hostname);
    intent.putExtra("roomId",roomId);
    startActivity(intent);
  }
  //这是显示在左上角的未读消息总数
  @Override
  public void showUnreadCount(long roomsCount, int mentionsCount) {
      boolean success = ShortcutBadger.applyCount(ChatMainActivity.this, mentionsCount);
      //toolbar.setUnreadBadge((int) roomsCount, mentionsCount);
  }

  @Override
  public void showAddServerScreen() {
    //LaunchUtil.showAddServerActivity(this);
  }

  @Override
  public void showLoginScreen() {
    LaunchUtil.showLoginActivity(this, hostname);
    //statusTicker.updateStatus(StatusTicker.STATUS_DISMISS, null);
  }

  @Override
  public void showConnectionError() {
    /*statusTicker.updateStatus(StatusTicker.STATUS_CONNECTION_ERROR,
        Snackbar.make(findViewById(getLayoutContainerForFragment()),
                getResources().getString(R.string.fragment_retry_login_error_title), Snackbar.LENGTH_INDEFINITE)
            .setAction(getResources().getString(R.string.fragment_retry_login_retry_title), view ->
                presenter.onRetryLogin()));*/
  }

  @Override
  public void showConnecting() {
    /*statusTicker.updateStatus(StatusTicker.STATUS_TOKEN_LOGIN,
        Snackbar.make(findViewById(getLayoutContainerForFragment()),
            getResources().getString(R.string.server_config_activity_authenticating), Snackbar.LENGTH_INDEFINITE));*/
  }

  @Override
  public void showConnectionOk() {
    //statusTicker.updateStatus(StatusTicker.STATUS_DISMISS, null);
  }

  @Override
  public void showSignedInServers(List<Pair<String, Pair<String, String>>> serverList) {
    /*final FrameLayout subPane = (FrameLayout) findViewById(R.id.sub_sliding_pane);
    if (subPane != null) {
      LinearLayout serverListContainer = subPane.findViewById(R.id.server_list_bar);
      View addServerButton = subPane.findViewById(R.id.btn_add_server);
      addServerButton.setOnClickListener(view -> showAddServerActivity());

      for (Pair<String, Pair<String, String>> server : serverList) {
        String serverHostname = server.first;
        Pair<String, String> serverInfoPair = server.second;
        String logoUrl = serverInfoPair.first;
        String siteName = serverInfoPair.second;
        //Log.i("bbbbb","服务端"+serverHostname+"  "+siteName+"  "+serverListContainer.findViewWithTag(serverHostname));
        if (serverListContainer.findViewWithTag(serverHostname) == null) {
          int serverCount = serverListContainer.getChildCount();

          View serverRow = LayoutInflater.from(this).inflate(R.layout.server_row, serverListContainer, false);
          ImageView serverButton = serverRow.findViewById(R.id.drawee_server_button);
          TextView hostnameLabel = serverRow.findViewById(R.id.text_view_server_label);
          TextView siteNameLabel = serverRow.findViewById(R.id.text_view_site_name_label);
          ImageView dotView = serverRow.findViewById(R.id.selected_server_dot);

          //serverButton.setTag(serverHostname);//You must not call setTag() on a view Glide is targeting
          hostnameLabel.setText(serverHostname);
          siteNameLabel.setText(siteName);

          // Currently selected server
          if (serverHostname.equalsIgnoreCase(hostname)) {
            serverRow.setSelected(true);
            dotView.setVisibility(View.VISIBLE);
          } else {
            dotView.setVisibility(View.GONE);
          }

          serverRow.setOnClickListener(view -> changeServerIfNeeded(serverHostname));
          Glide.with(this).load(logoUrl).apply(options).into(serverButton);
          //FrescoHelper.INSTANCE.loadImage(serverButton, logoUrl, ContextCompat.getDrawable(this, R.mipmap.ic_launcher));

          serverListContainer.addView(serverRow, serverCount - 1);
        }
      }
    }*/
  }

  private void changeServerIfNeeded(String serverHostname) {
    if (!hostname.equalsIgnoreCase(serverHostname)) {
      RocketChatCache rocketChatCache = new RocketChatCache(getApplicationContext());
      rocketChatCache.setSelectedServerHostname(serverHostname);
      recreate();
    }
  }


  private static class StatusTicker {
    public static final int STATUS_DISMISS = 0;
    public static final int STATUS_CONNECTION_ERROR = 1;
    public static final int STATUS_TOKEN_LOGIN = 2;

    private int status;
    private Snackbar snackbar;

    public StatusTicker() {
      status = STATUS_DISMISS;
    }

    public void updateStatus(int status, Snackbar snackbar) {
      if (status == this.status) {
        return;
      }
      this.status = status;
      if (this.snackbar != null) {
        this.snackbar.dismiss();
      }
      if (status != STATUS_DISMISS) {
        this.snackbar = snackbar;
        if (this.snackbar != null) {
          this.snackbar.show();
        }
      }
    }
  }
}
