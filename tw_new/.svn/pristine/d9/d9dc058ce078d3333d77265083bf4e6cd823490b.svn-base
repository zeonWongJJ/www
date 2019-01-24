package com.qidu.chat.fragment.sidebar;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.annotation.Nullable;
import android.support.v4.app.DialogFragment;
import android.support.v7.widget.DividerItemDecoration;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.support.v7.widget.SearchView;
import android.util.Log;
import android.view.MotionEvent;
import android.view.View;
import android.widget.CompoundButton;
import android.widget.TextView;

import com.luck.picture.lib.rxbus2.RxBus;
import com.luck.picture.lib.rxbus2.Subscribe;
import com.luck.picture.lib.rxbus2.ThreadMode;
import com.qidu.chat.BuildConfig;
import com.qidu.chat.R;
import com.qidu.chat.RocketChatCache;
import com.qidu.chat.activity.ChatRoomActivity;
import com.qidu.chat.api.MethodCallHelper;
import com.qidu.chat.fragment.AbstractFragment;
import com.qidu.chat.fragment.sidebar.dialog.AddChannelDialogFragment;
import com.qidu.chat.fragment.sidebar.dialog.AddDirectMessageDialogFragment;
import com.qidu.chat.helper.AbsoluteUrlHelper;
import com.qidu.chat.helper.KeyboardHelper;
import com.qidu.chat.helper.Logger;
import com.qidu.chat.layouthelper.chatroom.roomlist.ChannelRoomListHeader;
import com.qidu.chat.layouthelper.chatroom.roomlist.DirectMessageRoomListHeader;
import com.qidu.chat.layouthelper.chatroom.roomlist.FavoriteRoomListHeader;
import com.qidu.chat.layouthelper.chatroom.roomlist.LivechatRoomListHeader;
import com.qidu.chat.layouthelper.chatroom.roomlist.RoomListAdapter;
import com.qidu.chat.layouthelper.chatroom.roomlist.RoomListHeader;
import com.qidu.chat.layouthelper.chatroom.roomlist.UnreadRoomListHeader;
import com.qidu.chat.renderer.UserRenderer;

import bean.DefaultEventEntity;
import chat.rocket.core.interactors.RoomInteractor;
import chat.rocket.core.interactors.SessionInteractor;
import chat.rocket.core.models.RoomSidebar;
import chat.rocket.core.models.Spotlight;
import chat.rocket.core.models.User;
import chat.rocket.core.utils.CommonKey;
import chat.rocket.persistence.realm.repositories.RealmRoomRepository;
import chat.rocket.persistence.realm.repositories.RealmServerInfoRepository;
import chat.rocket.persistence.realm.repositories.RealmSessionRepository;
import chat.rocket.persistence.realm.repositories.RealmSpotlightRepository;
import chat.rocket.persistence.realm.repositories.RealmUserRepository;
import com.jakewharton.rxbinding2.support.v7.widget.RxSearchView;
import com.jakewharton.rxbinding2.widget.RxCompoundButton;

import common.Constants;
import io.reactivex.android.schedulers.AndroidSchedulers;
import io.reactivex.disposables.Disposable;

import java.util.ArrayList;
import java.util.List;

public class SidebarMainFragment extends AbstractFragment implements SidebarMainContract.View {
  private SidebarMainContract.Presenter presenter;
  private RoomListAdapter adapter;
  private SearchView searchView;
  private TextView loadMoreResultsText;
  private List<RoomSidebar> roomSidebarList;
  private Disposable spotlightDisposable;
  private String hostname;
  private static final String HOSTNAME = "hostname";



  public SidebarMainFragment() {}

  /**
   * create SidebarMainFragment with hostname.
   */
  public static SidebarMainFragment create(String hostname) {
    Bundle args = new Bundle();
    args.putString(HOSTNAME, hostname);

    SidebarMainFragment fragment = new SidebarMainFragment();
    fragment.setArguments(args);

    return fragment;
  }
  @Subscribe(threadMode = ThreadMode.MAIN)//如果是子线程记得切换ui线程更新ui
  public void eventBus(DefaultEventEntity obj) {
    if(obj.what==Constants.IM_LOGIN_OUT){
      //Log.i("aaaa","hahhahhahhah"+hostname+"");
      //presenter.bindView(this);
      adapter.clearAllData();
    }

  }
  @Override
  public void onDestroyView() {
    super.onDestroyView();
    if (RxBus.getDefault().isRegistered(this)) {
      RxBus.getDefault().unregister(this);
    }
  }
  @Override
  public void onCreate(@Nullable Bundle savedInstanceState) {
    super.onCreate(savedInstanceState);
    if (!RxBus.getDefault().isRegistered(this)) {
      RxBus.getDefault().register(this);
    }
    hostname = getArguments().getString(HOSTNAME);
    RealmUserRepository userRepository = new RealmUserRepository(hostname);

    AbsoluteUrlHelper absoluteUrlHelper = new AbsoluteUrlHelper(
        hostname,
        new RealmServerInfoRepository(),
        userRepository,
        new SessionInteractor(new RealmSessionRepository(hostname))
    );

    presenter = new SidebarMainPresenter(
        hostname,
        new RoomInteractor(new RealmRoomRepository(hostname)),
        userRepository,
        new RocketChatCache(getContext()),
        absoluteUrlHelper,
        new MethodCallHelper(getContext(), hostname),
        new RealmSpotlightRepository(hostname)
    );
  }

  @Override
  public void onResume() {
    super.onResume();
    presenter.bindView(this);
  }

  @Override
  public void onPause() {
    presenter.release();
    super.onPause();
  }

  @Override
  protected int getLayout() {
    return R.layout.fragment_sidebar_main;
  }


  @Override
  protected void onSetupView() {
    searchView = rootView.findViewById(R.id.search);
    TextView titleCenter=rootView.findViewById(R.id.header_text);
    titleCenter.setText("会话");
    adapter = new RoomListAdapter(hostname);
    adapter.setOnItemClickListener(new RoomListAdapter.OnItemClickListener() {
      @Override
      public void onItemClick(RoomSidebar roomSidebar) {
        searchView.clearFocus();
        presenter.onRoomSelected(roomSidebar);

        Intent intent=new Intent(getActivity(),ChatRoomActivity.class);
        intent.putExtra("hostname",hostname);
        intent.putExtra("roomId",roomSidebar.getRoomId());
        getActivity().startActivity(intent);
      }

      @Override
      public void onItemClick(Spotlight spotlight) {//搜索列表点击
        searchView.setQuery(null, false);
        searchView.clearFocus();
        presenter.onSpotlightSelected(spotlight);

        /*Intent intent=new Intent(getActivity(),ChatRoomActivity.class);
        intent.putExtra("hostname",hostname);
        intent.putExtra("roomId",spotlight.getRoomId());
        getActivity().startActivity(intent);*/
      }
    });

    RecyclerView recyclerView = rootView.findViewById(R.id.room_list_container);
    recyclerView.setLayoutManager(new LinearLayoutManager(getContext(), LinearLayoutManager.VERTICAL, false));
    DividerItemDecoration itemDecoration=new DividerItemDecoration(getActivity(),DividerItemDecoration.VERTICAL);
    //itemDecoration.setDrawable(getActivity().getResources().getDrawable(R.drawable.item_line_divider));
    recyclerView.addItemDecoration(itemDecoration);
    recyclerView.addOnItemTouchListener(new RecyclerView.OnItemTouchListener() {
      @Override
      public boolean onInterceptTouchEvent(RecyclerView rv, MotionEvent e) {
        switch (e.getAction()){
          case MotionEvent.ACTION_DOWN:
            clearSearchViewFocus();
            KeyboardHelper.hideSoftKeyboard(getActivity());
            break;
        }
        return false;
      }

      @Override
      public void onTouchEvent(RecyclerView rv, MotionEvent e) {

      }

      @Override
      public void onRequestDisallowInterceptTouchEvent(boolean disallowIntercept) {

      }
    });
    recyclerView.setAdapter(adapter);

    loadMoreResultsText = rootView.findViewById(R.id.text_load_more_results);

    RxSearchView.queryTextChanges(searchView)
            .observeOn(AndroidSchedulers.mainThread())
            .subscribe(charSequence -> {
                if (spotlightDisposable != null && !spotlightDisposable.isDisposed()) {
                    spotlightDisposable.dispose();
                }
                presenter.disposeSubscriptions();
                if (charSequence.length() == 0) {
                    loadMoreResultsText.setVisibility(View.GONE);
                    adapter.setMode(RoomListAdapter.MODE_ROOM);
                    presenter.bindView(this);
                } else {
                  SharedPreferences sp = getActivity().getSharedPreferences(CommonKey.KEY_LOGIN_USER_ID, Context.MODE_PRIVATE);
                  String localUserId = sp.getString("user_id", null);
                  if(localUserId==null){//如果退出登录了就不给搜索
                    return;
                  }
                  filterRoomSidebarList(charSequence);
                }
            });

    loadMoreResultsText.setOnClickListener(view -> loadMoreResults());
  }

  @Override
  public void showRoomSidebarList(@NonNull List<RoomSidebar> roomSidebarList) {
    this.roomSidebarList = roomSidebarList;
    adapter.setRoomSidebarList(roomSidebarList);
  }

  @Override
  public void filterRoomSidebarList(CharSequence term) {
      List<RoomSidebar> filteredRoomSidebarList = new ArrayList<>();

      for (RoomSidebar roomSidebar: roomSidebarList) {
          if (roomSidebar.getRoomName().contains(term)) {
              filteredRoomSidebarList.add(roomSidebar);
          }
      }

      if (filteredRoomSidebarList.isEmpty()) {
          loadMoreResults();
      } else {
          loadMoreResultsText.setVisibility(View.VISIBLE);
          adapter.setMode(RoomListAdapter.MODE_ROOM);
          adapter.setRoomSidebarList(filteredRoomSidebarList);
      }
  }


  private void loadMoreResults() {
    spotlightDisposable = presenter.searchSpotlight(searchView.getQuery().toString())
            .toObservable()
            .observeOn(AndroidSchedulers.mainThread())
            .subscribe(this::showSearchSuggestions);
  }

  private void showSearchSuggestions(List<Spotlight> spotlightList) {
    loadMoreResultsText.setVisibility(View.GONE);
    adapter.setMode(RoomListAdapter.MODE_SPOTLIGHT);
    adapter.setSpotlightList(spotlightList);
  }



  @Override
  public void showScreen() {
    rootView.setVisibility(View.VISIBLE);
  }

  @Override
  public void showEmptyScreen() {
    rootView.setVisibility(View.INVISIBLE);
  }

  @Override
  public void show(User user) {
    //onRenderCurrentUser(user);
    /*if(user==null){//退出登录的时候
      adapter.setRoomSidebarList(new ArrayList<>());
      adapter.setSpotlightList(new ArrayList<>());
      adapter.setRoomListHeaders(new ArrayList<>());
      return;
    }*/
    updateRoomListMode();
  }


  private void updateRoomListMode() {
    final List<RoomListHeader> roomListHeaders = new ArrayList<>();

    roomListHeaders.add(new UnreadRoomListHeader(
        getString(R.string.fragment_sidebar_main_unread_rooms_title)
    ));

    roomListHeaders.add(new FavoriteRoomListHeader(
        getString(R.string.fragment_sidebar_main_favorite_title)
    ));

    roomListHeaders.add(new LivechatRoomListHeader(
            getString(R.string.fragment_sidebar_main_livechat_title)
    ));

    roomListHeaders.add(new ChannelRoomListHeader(
        getString(R.string.fragment_sidebar_main_channels_title),
        () -> showAddRoomDialog(AddChannelDialogFragment.create(hostname))
    ));
    roomListHeaders.add(new DirectMessageRoomListHeader(
        getString(R.string.fragment_sidebar_main_direct_messages_title),
        () -> showAddRoomDialog(AddDirectMessageDialogFragment.create(hostname))
    ));

    adapter.setRoomListHeaders(roomListHeaders);
  }



  public void clearSearchViewFocus() {
    searchView.clearFocus();
  }



  private void showAddRoomDialog(DialogFragment dialog) {
    dialog.show(getFragmentManager(), "AbstractAddRoomDialogFragment");
  }

}