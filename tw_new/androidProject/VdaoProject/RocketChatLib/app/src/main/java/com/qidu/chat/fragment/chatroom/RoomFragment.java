package com.qidu.chat.fragment.chatroom;

import android.Manifest;
import android.app.Activity;
import android.content.ClipData;
import android.content.ClipboardManager;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.media.MediaPlayer;
import android.net.Uri;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.annotation.Nullable;
import android.support.design.widget.Snackbar;
import android.support.v13.view.inputmethod.InputConnectionCompat;
import android.support.v13.view.inputmethod.InputContentInfoCompat;
import android.support.v4.app.DialogFragment;
import android.support.v4.os.BuildCompat;
import android.support.v4.util.Pair;
import android.support.v7.app.AlertDialog;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.support.v7.widget.Toolbar;
import android.text.Editable;
import android.util.Log;
import android.view.Gravity;
import android.view.MotionEvent;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.hadisatrio.optional.Optional;
import com.luck.picture.lib.PictureSelector;
import com.luck.picture.lib.config.PictureConfig;
import com.luck.picture.lib.config.PictureMimeType;
import com.luck.picture.lib.entity.LocalMedia;
import com.luck.picture.lib.rxbus2.RxBus;
import com.luck.picture.lib.rxbus2.Subscribe;
import com.luck.picture.lib.rxbus2.ThreadMode;
import com.qidu.chat.fragment.ReceiveRedPacketDialogFragment;
import com.qidu.chat.layouthelper.chatroom.MessageFormManager;
import com.qidu.chat.layouthelper.extra_action.MessageExtraActionBehavior;
import com.sj.emoji.EmojiBean;


import org.json.JSONException;
import org.json.JSONObject;

import java.io.File;
import java.io.IOException;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import audiorecord.lib.audioUtil.AudioRecorderUtils;
import audiorecord.lib.audioUtil.PopupWindowFactory;
import audiorecord.lib.audioUtil.widget.RecordSoundImageView;
import bean.DefaultEventEntity;

import com.qidu.chat.BackgroundLooper;
import com.qidu.chat.R;
import com.qidu.chat.RocketChatCache;
import com.qidu.chat.activity.room.RoomActivity;
import com.qidu.chat.api.MethodCallHelper;
import com.qidu.chat.fragment.SendRedPacketDialogFragment;


import com.qidu.chat.fragment.chatroom.dialog.FileUploadProgressDialogFragment;
import com.qidu.chat.fragment.chatroom.dialog.SendLocationDialogFragment;
import com.qidu.chat.fragment.chatroom.dialog.UsersOfRoomDialogFragment;
import com.qidu.chat.helper.AbsoluteUrlHelper;
import com.qidu.chat.helper.FileUploadHelper;
import com.qidu.chat.helper.LoadMoreScrollListener;
import com.qidu.chat.helper.Logger;
import com.qidu.chat.helper.OnBackPressListener;
import com.qidu.chat.helper.RecyclerViewAutoScrollManager;
import com.qidu.chat.helper.RecyclerViewScrolledToBottomListener;
import com.qidu.chat.helper.TextUtils;
import com.qidu.chat.layouthelper.chatroom.AbstractNewMessageIndicatorManager;
import com.qidu.chat.layouthelper.chatroom.MessageListAdapter;
import com.qidu.chat.layouthelper.chatroom.MessagePopup;
import com.qidu.chat.layouthelper.chatroom.ModelListAdapter;
import com.qidu.chat.layouthelper.chatroom.PairedMessage;

import com.qidu.chat.renderer.RocketChatUserStatusProvider;
import com.qidu.chat.service.ConnectivityManager;
import com.qidu.chat.service.temp.DeafultTempSpotlightRoomCaller;
import com.qidu.chat.service.temp.DefaultTempSpotlightUserCaller;
import chat.rocket.android.widget.AbsoluteUrl;
import chat.rocket.android.widget.RoomToolbar;
import chat.rocket.android.widget.message.autocomplete.AutocompleteManager;
import chat.rocket.android.widget.message.autocomplete.channel.ChannelSource;
import chat.rocket.android.widget.message.autocomplete.user.UserSource;
import chat.rocket.core.interactors.AutocompleteChannelInteractor;
import chat.rocket.core.interactors.AutocompleteUserInteractor;
import chat.rocket.core.interactors.MessageInteractor;
import chat.rocket.core.interactors.SessionInteractor;
import chat.rocket.core.models.Message;
import chat.rocket.core.models.Room;
import chat.rocket.core.models.User;
import chat.rocket.core.utils.CommonKey;
import chat.rocket.persistence.realm.RealmStore;
import chat.rocket.persistence.realm.repositories.RealmMessageRepository;
import chat.rocket.persistence.realm.repositories.RealmRoomRepository;
import chat.rocket.persistence.realm.repositories.RealmServerInfoRepository;
import chat.rocket.persistence.realm.repositories.RealmSessionRepository;
import chat.rocket.persistence.realm.repositories.RealmSpotlightRoomRepository;
import chat.rocket.persistence.realm.repositories.RealmSpotlightUserRepository;
import chat.rocket.persistence.realm.repositories.RealmUserRepository;
import common.Constants;
import common.SimpleCommonUtils;
import common.data.AppBean;
import common.utils.VoicePlayingBgUtil;
import common.widget.SimpleAppsGridView;
import filepicker.filepicker.FilePickerActivity;
import filepicker.filepicker.PickerManager;
import filepicker.filepicker.model.FileEntity;
import io.reactivex.Single;
import io.reactivex.SingleSource;
import io.reactivex.android.schedulers.AndroidSchedulers;
import io.reactivex.disposables.CompositeDisposable;
import io.reactivex.disposables.Disposable;
import io.reactivex.functions.Function;
import me.leolin.shortcutbadger.ShortcutBadger;
import permissions.dispatcher.NeedsPermission;
import permissions.dispatcher.RuntimePermissions;
import redpacket.lib.DialogController;
import redpacket.lib.DialogHelper;
import sj.keyboard.XhsEmoticonsKeyBoard;
import sj.keyboard.data.EmoticonEntity;
import sj.keyboard.interfaces.EmoticonClickListener;
import sj.keyboard.widget.EmoticonsEditText;
import sj.keyboard.widget.FuncLayout;

import static android.content.Context.MODE_PRIVATE;

/**
 * Chat room screen.
 */
@RuntimePermissions
public class RoomFragment extends AbstractChatRoomFragment implements
        OnBackPressListener,FuncLayout.OnFuncKeyBoardListener,
        /*ChatFunctionFragment.Callback,*/SendRedPacketDialogFragment.SendRedPacketCallback,SendLocationDialogFragment.SendLocationCallback,
        ModelListAdapter.OnItemClickListener<PairedMessage>,
        ModelListAdapter.OnItemLongClickListener<PairedMessage>,
        RoomContract.View ,MediaPlayer.OnErrorListener, MediaPlayer.OnCompletionListener, MediaPlayer.OnBufferingUpdateListener,
        MediaPlayer.OnPreparedListener,MediaPlayer.OnVideoSizeChangedListener{
  private static int REQ__FILE_CODE = 0x01;//文件选择
  private String isSpotlight=null;//是否单聊
  private static final int DIALOG_ID = 1;
  private static final String HOSTNAME = "hostname";
  private static final String ROOM_ID = "roomId";

  private String hostname;
  private String token;
  private String userId;
  private String roomId;
  private String roomType;

  private LoadMoreScrollListener scrollListener;
  private MessageFormManager messageFormManager;
  private RecyclerView messageRecyclerView;
  private RecyclerViewAutoScrollManager recyclerViewAutoScrollManager;
  protected AbstractNewMessageIndicatorManager newMessageIndicatorManager;
  protected Snackbar unreadIndicator;
  private boolean previousUnreadMessageExists;
  private MessageListAdapter messageListAdapter;
  private AutocompleteManager autocompleteManager;


  private CompositeDisposable compositeDisposable = new CompositeDisposable();

  protected RoomContract.Presenter presenter;

  private RealmRoomRepository roomRepository;
  private RealmUserRepository userRepository;
  private MethodCallHelper methodCallHelper;
  private AbsoluteUrlHelper absoluteUrlHelper;

  private Message edittingMessage = null;

  private boolean isSHBSuccess=false;
  private String messageIdForSHB=null;
  private int positionForSHB=-1;
  //private SlidingPaneLayout pane;
  //private SidebarMainFragment sidebarFragment;
  private XhsEmoticonsKeyBoard ekBar;
  public RoomFragment() {}

  /**
   * create fragment with roomId.
   */
  public static RoomFragment create(String hostname, String roomId) {
    Bundle args = new Bundle();
    args.putString(HOSTNAME, hostname);
    args.putString(ROOM_ID, roomId);

    RoomFragment fragment = new RoomFragment();
    fragment.setArguments(args);

    return fragment;
  }
  /*hideAllLayout  隐藏表情控件和键盘*/

  @Override
  public void onCreate(@Nullable Bundle savedInstanceState) {
    super.onCreate(savedInstanceState);
    isSpotlight=new RocketChatCache(getActivity()).getSelectedRoomDirectMessageType();
    Bundle args = getArguments();
    hostname = args.getString(HOSTNAME);
    roomId = args.getString(ROOM_ID);
    //Log.i("aaaaaa",isSpotlight+"是否单聊参数");
    SimpleCommonUtils.hostName=hostname;
    roomRepository = new RealmRoomRepository(hostname);

    MessageInteractor messageInteractor = new MessageInteractor(
        new RealmMessageRepository(hostname),
        roomRepository
    );

    userRepository = new RealmUserRepository(hostname);

    absoluteUrlHelper = new AbsoluteUrlHelper(
        hostname,
        new RealmServerInfoRepository(),
        userRepository,
        new SessionInteractor(new RealmSessionRepository(hostname))
    );

    methodCallHelper = new MethodCallHelper(getContext(), hostname);



    presenter = new RoomPresenter(
        roomId,
        userRepository,
        messageInteractor,
        roomRepository,
        absoluteUrlHelper,
        methodCallHelper,
        ConnectivityManager.getInstance(getContext())
    );
    if (savedInstanceState == null) {
      presenter.loadMessages();
    }
    presenter.loadListEmojiCustom(getActivity());
  }

  @Override
  protected int getLayout() {
    return R.layout.fragment_room;
  }
  private Single<User> getCurrentUser() {
    RealmUserRepository userRepository = new RealmUserRepository(hostname);
    return userRepository.getCurrent()
            .filter(Optional::isPresent)
            .map(Optional::get)
            .firstElement()
            .toSingle();
  }
  @Subscribe(threadMode = ThreadMode.MAIN)//如果是子线程记得切换ui线程更新ui
  public void eventBus(DefaultEventEntity obj) {
    if(DialogController.receiveHandler==obj.what){
      Map<String,Object> map= (HashMap<String,Object>) obj.obj;
      String redPacketId= (String) map.get("redPacketId");
      String messageId= (String) map.get("messageId");
      int position= (int) map.get("position");
      messageIdForSHB=messageId;
      positionForSHB=position;
      Disposable subscription = getCurrentUser().flatMap(new Function<User, SingleSource<?>>() {
        @Override
        public SingleSource<?> apply(@io.reactivex.annotations.NonNull User user) throws Exception {
          try {
            JSONObject object=new JSONObject();
            object.put("redPacketId",redPacketId);
            object.put("timeTemp",System.currentTimeMillis());
            object.put("userId",user.getId());
            object.put("userName",user.getUsername());
            String params="bot:SHB:"+object.toString();
            isSHBSuccess=false;
            sendMessage(params);
          } catch (JSONException e) {
            e.printStackTrace();
          }
          return Single.just(user);
        }
      }).subscribeOn(AndroidSchedulers.from(BackgroundLooper.get()))
              .observeOn(AndroidSchedulers.mainThread())
              .subscribe();
    }else if(obj.what==0x222){//RocketChatMessageLayout 里面发送的

    }else if(obj.what==Constants.RED_PACKET_CLICK_DIALOG){
      Map<String,Object> map= (HashMap<String,Object>) obj.obj;
      String messageId= (String) map.get("messageId");
      String response= (String) map.get("response");
      int position= (int) map.get("position");
      if(response==null){
        return;
      }
      //String response=messageBody.replace("bot:FHB:","");
      String receiveState="";
      try {
        JSONObject jsonObject=new JSONObject(response);
        receiveState=jsonObject.getString("receiveState");
        if(receiveState.equals("yes")){
          Toast.makeText(getActivity(),"红包已经被领了",Toast.LENGTH_SHORT).show();
          //将收到红包信息显示
          String message= "hhhhhhh";
          final DialogFragment fragment = ReceiveRedPacketDialogFragment
                  .create(new String(message));
          fragment.setTargetFragment(this, 2);
          fragment.show(getFragmentManager(), "ReceiveRedPacketDialogFragment");
        }else {
          //开红包弹窗
          //提供一个红包id,让知道抢了哪个红包
          DialogHelper.DilaogBean bean=new DialogHelper.DilaogBean();
          bean.setReceiveMessage(response);
          bean.setMessageId(messageId);
          bean.setPosition(position);
          //传一个消息id，修改红包被点击后的状态
          new DialogController(getActivity()).showDilaog(bean);
        }
      } catch (JSONException e) {
        e.printStackTrace();
      }
    }
  }
  private VoicePlayingBgUtil voicePlayingBgUtil,lastVoicePlayingBgUtil;

  private View.OnClickListener audioClickListener=new View.OnClickListener() {
    @Override
    public void onClick(View view) {
      String path= (String) view.getTag(R.id.tag_voice_path);
      if(voicePlayingBgUtil!=null){//很重要,必须先停止旧的
        lastVoicePlayingBgUtil=voicePlayingBgUtil;
        voicePlayingBgUtil.stopPlay();
      }
      voicePlayingBgUtil= (VoicePlayingBgUtil) view.getTag(R.id.tag_voice_animation);
      if(!isPlaying){
        isPlaying =true;
        startPlaySound(path);
        voicePlayingBgUtil.voicePlay();
      }else if(isPlaying&&lastVoicePlayingBgUtil!=voicePlayingBgUtil){
        isPlaying =true;
        startPlaySound(path);
        voicePlayingBgUtil.voicePlay();
      }else {
        isPlaying =false;
        stopPlaySound();
      }
    }
  };

  @Override
  public void onDestroy() {
    super.onDestroy();
    if (mediaPlayer != null) {
      mediaPlayer.stop();
      mediaPlayer.release();
    }
    if (RxBus.getDefault().isRegistered(this)) {
      RxBus.getDefault().unregister(this);
    }
  }

  @Override
  protected void onSetupView() {
    if (!RxBus.getDefault().isRegistered(this)) {
      RxBus.getDefault().register(this);
    }
    //pane = getActivity().findViewById(R.id.sliding_pane);
    messageRecyclerView = rootView.findViewById(R.id.messageRecyclerView);

    messageListAdapter = new MessageListAdapter(getActivity(), hostname);
    messageListAdapter.setAudioClickListener(audioClickListener);
    messageRecyclerView.setAdapter(messageListAdapter);
    messageListAdapter.setOnItemClickListener(this);
    messageListAdapter.setOnItemLongClickListener(this);

    LinearLayoutManager linearLayoutManager = new LinearLayoutManager(getContext(), LinearLayoutManager.VERTICAL, true);
    messageRecyclerView.setLayoutManager(linearLayoutManager);
    recyclerViewAutoScrollManager = new RecyclerViewAutoScrollManager(linearLayoutManager) {
      @Override
      protected void onAutoScrollMissed() {
        if (newMessageIndicatorManager != null) {
          presenter.onUnreadCount();
        }
      }
    };
    messageListAdapter.registerAdapterDataObserver(recyclerViewAutoScrollManager);

    scrollListener = new LoadMoreScrollListener(linearLayoutManager, 40) {
      @Override
      public void requestMoreItem() {
        presenter.loadMoreMessages();
      }

      @Override
      public void onTouchScrollByHand() {
        if(ekBar!=null){
          ekBar.reset();
        }
      }
    };
    messageRecyclerView.addOnScrollListener(scrollListener);
    messageRecyclerView.addOnScrollListener(new RecyclerViewScrolledToBottomListener(linearLayoutManager, 1, this::markAsReadIfNeeded));

    messageRecyclerView.addOnItemTouchListener(new RecyclerView.OnItemTouchListener() {
      @Override
      public boolean onInterceptTouchEvent(RecyclerView rv, MotionEvent e) {
        switch (e.getAction()){
          case MotionEvent.ACTION_DOWN:
            if(ekBar!=null){
              ekBar.reset();
            }
            break;
        }
        return false;
      }
      @Override
      public void onTouchEvent(RecyclerView rv, MotionEvent e) {}
      @Override
      public void onRequestDisallowInterceptTouchEvent(boolean disallowIntercept) {}
    });
    newMessageIndicatorManager = new AbstractNewMessageIndicatorManager() {
      @Override
      protected void onShowIndicator(int count, boolean onlyAlreadyShown) {
        if ((onlyAlreadyShown && unreadIndicator != null && unreadIndicator.isShown()) || !onlyAlreadyShown) {
          unreadIndicator = getUnreadCountIndicatorView(count);
          unreadIndicator.show();
        }
      }

      @Override
      protected void onHideIndicator() {
        if (unreadIndicator != null && unreadIndicator.isShown()) {
          unreadIndicator.dismiss();
        }
      }
    };
    initAudio();
    Log.i("bbbbb",isSpotlight+"    "+Room.TYPE_CHANNEL);
    if(isSpotlight!=null) {
      if (isSpotlight.equals(Room.TYPE_CHANNEL)) {
        RoomToolbar toolbar = getActivity().findViewById(R.id.activity_main_toolbar);
        toolbar.getAddView().setVisibility(View.VISIBLE);
        toolbar.getAddView().setOnClickListener(view -> {
          UsersOfRoomDialogFragment.create(roomId, hostname)
                  .show(getFragmentManager(), "UsersOfRoomDialogFragment");
        });
      }
    }
    setupSidebar();
    /*
    setupSideMenu();*/
    setupMessageComposer();


  }


  private void scrollToLatestMessage() {
    if (messageRecyclerView != null)
      messageRecyclerView.scrollToPosition(0);
  }

  protected Snackbar getUnreadCountIndicatorView(int count) {
    // TODO: replace with another custom View widget, not to hide message composer.
    final String caption = getResources().getQuantityString(
        R.plurals.fmt_dialog_view_latest_message_title, count, count);

    return Snackbar.make(rootView, caption, Snackbar.LENGTH_LONG)
        .setAction(R.string.dialog_view_latest_message_action, view -> scrollToLatestMessage());
  }

  @Override
  public void onDestroyView() {
    RecyclerView.Adapter adapter = messageRecyclerView.getAdapter();
      if (adapter != null)
        adapter.unregisterAdapterDataObserver(recyclerViewAutoScrollManager);

    compositeDisposable.clear();

    if (autocompleteManager != null) {
      autocompleteManager.dispose();
      autocompleteManager = null;
    }

    super.onDestroyView();
  }

  @Override
  public void onItemClick(PairedMessage pairedMessage) {
    //presenter.onMessageSelected(pairedMessage.target);
    presenter.onMessageTap(pairedMessage.target);
  }

  @Override
  public boolean onItemLongClick(PairedMessage pairedMessage) {
    /*MessageOptionsDialogFragment messageOptionsDialogFragment = MessageOptionsDialogFragment
        .create(pairedMessage.target);

    messageOptionsDialogFragment.setOnMessageOptionSelectedListener(message -> {
      messageOptionsDialogFragment.dismiss();
      onEditMessage(message);
    });

    messageOptionsDialogFragment.show(getChildFragmentManager(), "MessageOptionsDialogFragment");*/
    presenter.onMessageSelected(pairedMessage.target);
    return true;
  }

  @Override
  public void onSuccessCallBack(String message) {//发红包参数
    sendMessage(message);
  }
  //发送地理位置
  @Override
  public void onSuccessLocationCallBack(String message) {
    sendMessage(message);
  }
  /*private void setupSideMenu() {
    View sideMenu = rootView.findViewById(R.id.room_side_menu);
    sideMenu.findViewById(R.id.btn_users).setOnClickListener(view -> {
      UsersOfRoomDialogFragment.create(roomId, hostname)
          .show(getFragmentManager(), "UsersOfRoomDialogFragment");
      //closeSideMenuIfNeeded();
    });

    DrawerLayout drawerLayout = rootView.findViewById(R.id.drawer_layout);
    if (drawerLayout != null && pane != null) {
      compositeDisposable.add(RxDrawerLayout.drawerOpen(drawerLayout, GravityCompat.END)
          .compose(bindToLifecycle())
          .subscribe(
              opened -> {
                try {
                  Field fieldSlidable = pane.getClass().getDeclaredField("mCanSlide");
                  fieldSlidable.setAccessible(true);
                  fieldSlidable.setBoolean(pane, !opened);
                } catch (Exception exception) {
                  RCLog.w(exception);
                }
              },
              Logger::report
          )
      );
    }
  }*/

  private void setupSidebar() {

    Toolbar toolbar = getActivity().findViewById(R.id.activity_main_toolbar);
    toolbar.getMenu().clear();
    toolbar.inflateMenu(R.menu.menu_room);

    /*optionalPane.ifPresent(pane -> toolbar.setNavigationOnClickListener(view -> {
      if (pane.isSlideable() && !pane.isOpen()) {
        pane.openPane();
      }
    }));*/

    toolbar.setOnMenuItemClickListener(menuItem -> {
      int i = menuItem.getItemId();
      if (i == R.id.action_pinned_messages) {
        showRoomListFragment(R.id.action_pinned_messages);

      } else if (i == R.id.action_favorite_messages) {
        showRoomListFragment(R.id.action_favorite_messages);

      } else if (i == R.id.action_file_list) {
        showRoomListFragment(R.id.action_file_list);

      } else if (i == R.id.action_member_list) {
        showRoomListFragment(R.id.action_member_list);

      } else {
        return super.onOptionsItemSelected(menuItem);
      }
      return true;
    });

    /*SlidingPaneLayout subPane = getActivity().findViewById(R.id.sub_sliding_pane);
    RoomToolbar toolbar = getActivity().findViewById(R.id.activity_main_toolbar);
    //sidebarFragment = (SidebarMainFragment) getActivity().getSupportFragmentManager().findFragmentById(R.id.sidebar_fragment_container);

    pane.setPanelSlideListener(new SlidingPaneLayout.PanelSlideListener() {
      @Override
      public void onPanelSlide(View view, float v) {
        messageFormManager.enableComposingText(false);
        //sidebarFragment.clearSearchViewFocus();
        //Ref: ActionBarDrawerToggle#setProgress
        toolbar.setNavigationIconProgress(v);
      }

      @Override
      public void onPanelOpened(View view) {
        toolbar.setNavigationIconVerticalMirror(true);
      }

      @Override
      public void onPanelClosed(View view) {
        messageFormManager.enableComposingText(true);
        toolbar.setNavigationIconVerticalMirror(false);
        subPane.closePane();
        //closeUserActionContainer();
      }
    });

    toolbar.setNavigationOnClickListener(view -> {
      if (pane.isSlideable() && !pane.isOpen()) {
        pane.openPane();
      }
    });*/
  }

  /*public void closeUserActionContainer() {
      sidebarFragment.closeUserActionContainer();
  }*/

  /*private boolean closeSideMenuIfNeeded() {
    DrawerLayout drawerLayout = rootView.findViewById(R.id.drawer_layout);
    if (drawerLayout != null && drawerLayout.isDrawerOpen(GravityCompat.END)) {
      drawerLayout.closeDrawer(GravityCompat.END);
      return true;
    }
    return false;
  }*/

  private void setupMessageComposer() {
    /*final MessageFormLayout messageFormLayout = rootView.findViewById(R.id.messageComposer);
    messageFormLayout.initData(this,hostname,new ArrayList<>(extraActionItems));*/
    initEmoticonsKeyBoardBar();
    messageFormManager = new MessageFormManager(ekBar, this::showExtraActionSelectionDialog);
    messageFormManager.setSendMessageCallback(this::sendMessage);
    ekBar.setEditTextCommitContentListener(this::onCommitContent);

    autocompleteManager = new AutocompleteManager(rootView.findViewById(R.id.messageListRelativeLayout));

    autocompleteManager.registerSource(
        new ChannelSource(
            new AutocompleteChannelInteractor(
                roomRepository,
                new RealmSpotlightRoomRepository(hostname),
                new DeafultTempSpotlightRoomCaller(methodCallHelper)
            ),
            AndroidSchedulers.from(BackgroundLooper.get()),
            AndroidSchedulers.mainThread()
        )
    );

    Disposable disposable = Single.zip(
        absoluteUrlHelper.getRocketChatAbsoluteUrl(),
        roomRepository.getById(roomId).first(Optional.absent()),
        Pair::create
    )
        .subscribe(
            pair -> {
              if (pair.first.isPresent() && pair.second.isPresent()) {
                autocompleteManager.registerSource(
                    new UserSource(
                        new AutocompleteUserInteractor(
                            pair.second.get(),
                            userRepository,
                            new RealmMessageRepository(hostname),
                            new RealmSpotlightUserRepository(hostname),
                            new DefaultTempSpotlightUserCaller(methodCallHelper)
                        ),
                        pair.first.get(),
                        RocketChatUserStatusProvider.INSTANCE,
                        AndroidSchedulers.from(BackgroundLooper.get()),
                        AndroidSchedulers.mainThread()
                    )
                );
              }
            },
            Logger::report
        );

    compositeDisposable.add(disposable);

    autocompleteManager.bindTo(
        ekBar.getEtChat(),
            ekBar
    );
  }

  @Override
  public void onActivityResult(int requestCode, int resultCode, Intent data) {
    super.onActivityResult(requestCode, resultCode, data);
    /*if (requestCode != AbstractUploadActionItem.RC_UPL || resultCode != RESULT_OK) {
      return;
    }*/
    /*if (data == null || data.getData() == null) {
      return;
    }*/
    if (requestCode==PictureConfig.CHOOSE_REQUEST&&resultCode == getActivity().RESULT_OK) {

          // 图片选择结果回调
          List<LocalMedia> selectList = PictureSelector.obtainMultipleResult(data);
          // 例如 LocalMedia 里面返回三种path
          // 1.media.getPath(); 为原图path
          // 2.media.getCutPath();为裁剪后path，需判断media.isCut();是否为true
          // 3.media.getCompressPath();为压缩后path，需判断media.isCompressed();是否为true
          // 如果裁剪并压缩了，以取压缩路径为准，因为是先裁剪后压缩的
          if(selectList.isEmpty()){
            return;
          }
      LocalMedia media=selectList.get(0);
      int mimeType = media.getMimeType();//PictureConfig.TYPE_IMAGE
      String path = "";
      if (media.isCut() && !media.isCompressed()) {
        // 裁剪过
        path = media.getCutPath();
      } else if (media.isCompressed() || (media.isCut() && media.isCompressed())) {
        // 压缩过,或者裁剪同时压缩过,以最终压缩过图片为准
        path = media.getCompressPath();
      } else {
        // 原图
        path = media.getPath();
      }
      if (!android.text.TextUtils.isEmpty(path)) {
        Uri uri = Uri.fromFile(new File(path));
        uploadFile(uri,true);
      }
    }/*else if(requestCode==0x12&&resultCode == RESULT_OK){
      if (data == null || data.getData() == null) {
        return;
      }
      uploadFile(data.getData(),false);

    }*/
    else if(requestCode == REQ__FILE_CODE){
      List<FileEntity> list=PickerManager.getInstance().files;
      if(list==null||list.isEmpty()){
        return;
      }
      String path=list.get(0).getPath();
      if (!android.text.TextUtils.isEmpty(path)) {
        Uri uri = Uri.fromFile(new File(path));
        uploadFile(uri,true);
      }
    }
  }

  private void uploadFile(Uri uri,boolean isExternal) {
    String uplId = new FileUploadHelper(getContext(), RealmStore.get(hostname))
        .requestUploading(roomId, uri,isExternal);
    if (!TextUtils.isEmpty(uplId)) {
      FileUploadProgressDialogFragment.create(hostname, roomId, uplId)
          .show(getFragmentManager(), "FileUploadProgressDialogFragment");
    } else {
      // show error.
    }
  }

  private void markAsReadIfNeeded() {
    presenter.onMarkAsRead();
  }

  @Override
  public void onResume() {
    super.onResume();
    presenter.bindView(this);
    //closeSideMenuIfNeeded();
  }

  @Override
  public void onPause() {
    presenter.release();
    super.onPause();
    ekBar.reset();

    if (/*getActivity().isFinishing() &&*/ mediaPlayer != null){   mediaPlayer.stop();
      mediaPlayer.release();
      mediaPlayer = null;
    }
    if(voicePlayingBgUtil!=null){
      voicePlayingBgUtil.stopPlay();
    }
  }

  private void showExtraActionSelectionDialog() {
    /*final DialogFragment fragment = ExtraActionPickerDialogFragment
        .create(new ArrayList<>(extraActionItems));
    fragment.setTargetFragment(this, DIALOG_ID);
    fragment.show(getFragmentManager(), "ExtraActionPickerDialogFragment");*/
  }
  private String sendRedPacketFlag=null;

  @Override
  public boolean onBackPressed() {
    if (edittingMessage != null) {
      edittingMessage = null;
      messageFormManager.clearComposingText();
      return true;
    }
    return false;
  }

  @Override
  public void onRequestPermissionsResult(int requestCode, @NonNull String[] permissions,
                                         @NonNull int[] grantResults) {
    super.onRequestPermissionsResult(requestCode, permissions, grantResults);
    RoomFragmentPermissionsDispatcher.onRequestPermissionsResult(this, requestCode, grantResults);
  }
  @NeedsPermission(Manifest.permission.READ_EXTERNAL_STORAGE)
  protected void onExtraActionSelected(MessageExtraActionBehavior action) {
    action.handleItemSelectedOnFragment(RoomFragment.this);
  }

  private boolean onCommitContent(InputContentInfoCompat inputContentInfo, int flags,
                                  Bundle opts, String[] supportedMimeTypes) {
    boolean supported = false;
    for (final String mimeType : supportedMimeTypes) {
      if (inputContentInfo.getDescription().hasMimeType(mimeType)) {
        supported = true;
        break;
      }
    }

    if (!supported) {
      return false;
    }

    if (BuildCompat.isAtLeastNMR1()
        && (flags & InputConnectionCompat.INPUT_CONTENT_GRANT_READ_URI_PERMISSION) != 0) {
      try {
        inputContentInfo.requestPermission();
      } catch (Exception e) {
        Logger.report(e);
        return false;
      }
    }

    Uri linkUri = inputContentInfo.getLinkUri();
    if (linkUri == null) {
      return false;
    }

    sendMessage(linkUri.toString());

    try {
      inputContentInfo.releasePermission();
    } catch (Exception e) {
      Logger.report(e);
    }

    return true;
  }

  private void sendMessage(String messageText) {
    if (edittingMessage == null) {
      presenter.sendMessage(messageText);
    } else {
      presenter.updateMessage(edittingMessage, messageText);
    }
  }

  @Override
  public void setupWith(RocketChatAbsoluteUrl rocketChatAbsoluteUrl) {
    if (rocketChatAbsoluteUrl != null) {
      token = rocketChatAbsoluteUrl.getToken();
      userId = rocketChatAbsoluteUrl.getUserId();
      messageListAdapter.setAbsoluteUrl(rocketChatAbsoluteUrl);
    }
  }

  @Override
  public void render(Room room) {
    roomType = room.getType();
    setToolbarTitle(room.getName());

    boolean unreadMessageExists = room.isAlert();
    if (newMessageIndicatorManager != null && previousUnreadMessageExists && !unreadMessageExists) {
      newMessageIndicatorManager.reset();
    }
    previousUnreadMessageExists = unreadMessageExists;

    if (room.isChannel()) {
      showToolbarPublicChannelIcon();
      return;
    }

    if (room.isPrivate()) {
      showToolbarPrivateChannelIcon();
    }

    if (room.isLivechat()) {
      showToolbarLivechatChannelIcon();
    }
  }

  @Override
  public void showUserStatus(User user) {
    showToolbarUserStatuslIcon(user.getStatus());
  }

  @Override
  public void updateHistoryState(boolean hasNext, boolean isLoaded) {
    if (messageRecyclerView == null || !(messageRecyclerView.getAdapter() instanceof MessageListAdapter)) {
      return;
    }

    MessageListAdapter adapter = (MessageListAdapter) messageRecyclerView.getAdapter();
    if (isLoaded) {
      scrollListener.setLoadingDone();
    }
    adapter.updateFooter(hasNext, isLoaded);
  }

  @Override
  public void onMessageSendSuccessfully() {
    SharedPreferences sp = getActivity().getSharedPreferences("sendRedPacketFlag", Context.MODE_PRIVATE);
    sendRedPacketFlag = sp.getString("sendRedPacketFlag", null);

    if(sendRedPacketFlag!=null){
      Intent intent = new Intent();
      //指定发送广播的频道
      intent.setAction("send.red.packet.success.state");
      //发送广播的数据
      intent.putExtra("successState","success");
      //发送
      getActivity().sendBroadcast(intent);
      //重置状态
      SharedPreferences pref = getActivity().getSharedPreferences("sendRedPacketFlag",MODE_PRIVATE);
      SharedPreferences.Editor editor = pref.edit();
      editor.putString("sendRedPacketFlag",null);
      editor.commit();
    }
    isSHBSuccess=true;
    if(isSHBSuccess&&messageIdForSHB!=null&&positionForSHB!=-1){
      Log.i("bbbbb","SHB onMessageSendSuccessfully=="+isSHBSuccess+"");
      messageListAdapter.updateRedPacketStatues(messageIdForSHB,positionForSHB);
      messageIdForSHB=null;
      isSHBSuccess=false;
      positionForSHB=-1;
    }
    scrollToLatestMessage();
    messageFormManager.onMessageSend();
    edittingMessage = null;
  }

  @Override
  public void disableMessageInput() {
    messageFormManager.enableComposingText(false);
  }

  @Override
  public void enableMessageInput() {
    messageFormManager.enableComposingText(true);
  }

  @Override
  public void showUnreadCount(int count) {
    ShortcutBadger.applyCount(getActivity(), count);
    newMessageIndicatorManager.updateNewMessageCount(count);
  }

  @Override
  public void showMessages(List<Message> messages) {
    if (messageListAdapter == null) {
      return;
    }
    messageListAdapter.updateData(messages);
  }

  @Override
  public void showMessageSendFailure(Message message) {
    SharedPreferences sp = getActivity().getSharedPreferences("sendRedPacketFlag", Context.MODE_PRIVATE);
    sendRedPacketFlag = sp.getString("sendRedPacketFlag", null);

    if(sendRedPacketFlag!=null){
      Intent intent = new Intent();
      //指定发送广播的频道
      intent.setAction(CommonKey.KEY_SEND_RED_PACKET_SUCCESS_STATE);
      intent.putExtra("successState","failure");
      getActivity().sendBroadcast(intent);
      //重置状态
      SharedPreferences pref = getActivity().getSharedPreferences("sendRedPacketFlag",MODE_PRIVATE);
      SharedPreferences.Editor editor = pref.edit();
      editor.putString("sendRedPacketFlag",null);
      editor.commit();
    }
    if(isSHBSuccess&&messageIdForSHB!=null){
      isSHBSuccess=false;
      messageIdForSHB=null;
      positionForSHB=-1;
    }
    new AlertDialog.Builder(getContext())
        .setPositiveButton(R.string.resend,
            (dialog, which) -> presenter.resendMessage(message))
        .setNegativeButton(android.R.string.cancel, null)
        .setNeutralButton(R.string.discard,
            (dialog, which) -> presenter.deleteMessage(message))
        .show();
  }

  @Override
  public void autoloadImages() {
    messageListAdapter.setAutoloadImages(true);
  }

  @Override
  public void manualLoadImages() {
    messageListAdapter.setAutoloadImages(true);
  }

  @Override
  public void onReply(AbsoluteUrl absoluteUrl, String markdown, Message message) {
    messageFormManager.setReply(absoluteUrl, markdown, message);
  }

  @Override
  public void onCopy(String message) {
    //RocketChatApplication context = RocketChatApplication.getInstance();
    ClipboardManager clipboardManager =
            (ClipboardManager) getActivity().getSystemService(Context.CLIPBOARD_SERVICE);
    clipboardManager.setPrimaryClip(ClipData.newPlainText("message", message));
  }

  @Override
  public void showMessageActions(Message message) {
    Activity context = getActivity();
    if (context != null /*&& context instanceof ChatMainActivity*/) {
      MessagePopup.take(message)
              .setReplyAction(msg -> presenter.replyMessage(message, false))
              .setEditAction(this::onEditMessage)
              .setCopyAction(msg -> onCopy(message.getMessage()))
              .setQuoteAction(msg -> presenter.replyMessage(message, true))
              .showWith(context);
    }
  }

  private void onEditMessage(Message message) {
    edittingMessage = message;
    messageFormManager.setEditMessage(message.getMessage());
  }

  private void showRoomListFragment(int actionId) {
    if (getActivity() != null) {
      Intent intent = new Intent(getActivity(), RoomActivity.class).putExtra("actionId", actionId)
              .putExtra("roomId", roomId)
              .putExtra("roomType", roomType)
              .putExtra("hostname", hostname)
              .putExtra("token", token)
              .putExtra("userId", userId);
      startActivity(intent);
    }
  }

  private AdapterView.OnItemClickListener gridItemClickListener=new AdapterView.OnItemClickListener() {
    @Override
    public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {
      ekBar.reset();
      AppBean data= (AppBean) adapterView.getAdapter().getItem(i);
      switch (data.getId()){
        case 1:
          chooseMode= PictureMimeType.ofAll();
          isShowCamera=false;
          openGallery(RoomFragment.this,new ArrayList<>());
          break;
        case 2:
          chooseMode= PictureMimeType.ofImage();
          isShowCamera=true;
          openCamera(RoomFragment.this,new ArrayList<>());
          break;
        case 3:
          chooseMode= PictureMimeType.ofVideo();
          isShowCamera=true;
          openCamera(RoomFragment.this,new ArrayList<>());
          break;
        case 4:
          sendRedPacketFlag="sendRedPacketDoing";
          SharedPreferences pref = getActivity().getSharedPreferences("sendRedPacketFlag",MODE_PRIVATE);
          SharedPreferences.Editor editor = pref.edit();
          editor.putString("sendRedPacketFlag",sendRedPacketFlag);
          editor.commit();

          final DialogFragment fragment = SendRedPacketDialogFragment
                  .create(new String(isSpotlight),hostname,roomId);
          fragment.setTargetFragment(RoomFragment.this, DIALOG_ID);
          fragment.show(getFragmentManager(), "SendRedPacketDialogFragment");
          break;
        case 5:
          Toast.makeText(getActivity(),"该功能暂未开放",Toast.LENGTH_SHORT).show();
          break;
        case 6:
          Intent intent = new Intent(getActivity(), FilePickerActivity.class);
          startActivityForResult(intent,REQ__FILE_CODE);
          break;
        case 7:
          DialogFragment mFragment = SendLocationDialogFragment
                  .create(new String(isSpotlight));
          mFragment.setTargetFragment(RoomFragment.this, DIALOG_ID);
          mFragment.show(getFragmentManager(), "SendLocationDialogFragment");
          break;
        default:
      }
    }
  };
  /*所有和键盘相关*/
  private void initEmoticonsKeyBoardBar() {
    ekBar=rootView.findViewById(R.id.ek_bar);
    //ekBar.setFuncViewHeight(200);
    SimpleCommonUtils.initEmoticonsEditText(ekBar.getEtChat());
    ekBar.setAdapter(SimpleCommonUtils.getCommonAdapter(getActivity(), emoticonClickListener));
    ekBar.addOnFuncKeyBoardListener(this);
    SimpleAppsGridView appsGridView=new SimpleAppsGridView(this,gridItemClickListener);
    //appsGridView.refreshDataChange(new ArrayList<>(extraActionItems));
    ekBar.addFuncView(appsGridView);

    ekBar.getEtChat().setOnSizeChangedListener(new EmoticonsEditText.OnSizeChangedListener() {
      @Override
      public void onSizeChanged(int w, int h, int oldw, int oldh) {
        scrollToLatestMessage();
      }
    });

    ekBar.getEmoticonsToolBarView().addFixedToolItemView(false, R.drawable.icon_add, null, new View.OnClickListener() {
      @Override
      public void onClick(View v) {
        Toast.makeText(getActivity(), "ADD", Toast.LENGTH_SHORT).show();
      }
    });
    ekBar.getEmoticonsToolBarView().addToolItemView(R.drawable.icon_setting, new View.OnClickListener() {
      @Override
      public void onClick(View v) {
        Toast.makeText(getActivity(), "SETTING", Toast.LENGTH_SHORT).show();
      }
    });
    //语音
    ekBar.getBtnVoice().setOnRecordListener(new RecordSoundImageView.OnRecordListener(){

      @Override
      public void onStartRecord() {
        /*if(hasPermission(Manifest.permission.RECORD_AUDIO)){
          mPop.showAtLocation(rootView.findViewById(R.id.messageListRelativeLayout), Gravity.CENTER,0,0);
          mAudioRecorderUtils.startRecord();
        }else {
          showAudioPermission();
        }*/
        mPop.showAtLocation(rootView.findViewById(R.id.messageListRelativeLayout), Gravity.CENTER,0,0);
        mAudioRecorderUtils.startRecord();
      }

      @Override
      public void onEndRecord() {
        mAudioRecorderUtils.stopRecord();//结束录音（保存录音文件）
        mPop.dismiss();
      }

      @Override
      public void onQuickClick() {

      }

      @Override
      public void onCancelRecord() {
        mAudioRecorderUtils.cancelRecord();//结束录音（保存录音文件）
        mPop.dismiss();
      }

      @Override
      public void onChangePopBackground(boolean isCancel) {
        isDoingCancel=isCancel;
        if(mImageView==null){
          return;
        }
        if(isCancel){
          mTextView.setText("松开手指,取消发送");
          mImageView.setImageDrawable(getActivity().getResources().getDrawable(R.mipmap.ic_launcher));
        }else {
          mImageView.setImageDrawable(getActivity().getResources().getDrawable(R.drawable.record_microphone));
        }
      }
    });
  }
  //录音相关
  private ImageView mImageView;
  private TextView mTextView;
  private AudioRecorderUtils mAudioRecorderUtils;
  private PopupWindowFactory mPop;
  private boolean isDoingCancel=false;
  protected void initAudio(){
    //PopupWindow的布局文件
    final View view = View.inflate(getActivity(), R.layout.layout_microphone, null);
    mPop = new PopupWindowFactory(getActivity(),view);
    //PopupWindow布局文件里面的控件
    mImageView = (ImageView) view.findViewById(R.id.iv_recording_icon);
    mTextView = (TextView) view.findViewById(R.id.tv_recording_time);
    mAudioRecorderUtils = new AudioRecorderUtils();
    //录音回调
    mAudioRecorderUtils.setOnAudioStatusUpdateListener(new AudioRecorderUtils.OnAudioStatusUpdateListener() {
      //录音中....db为声音分贝，time为录音时长
      @Override
      public void onUpdate(double db, long time) {
        if(!isDoingCancel){
          mImageView.getDrawable().setLevel((int) (3000 + 6000 * db / 100));
          mTextView.setText(long2String(time)+"\n"+"手指上滑,取消发送");
        }
        //声音太小
      }
      //录音结束，filePath为保存路径
      @Override
      public void onStop(String filePath) {
        if (!android.text.TextUtils.isEmpty(filePath)) {
          Uri uri = Uri.fromFile(new File(filePath));
          //uploadFile(uri,true);
          String uplId = new FileUploadHelper(getContext(), RealmStore.get(hostname))
                  .requestUploading(roomId, uri,true);

        } else {
          Toast.makeText(getActivity(), "录音时间太短,请重试!" + filePath, Toast.LENGTH_SHORT).show();
        }
      }
    });

  }



  //毫秒转秒
  public static String long2String(long time){
    //毫秒转秒
    int sec = (int) time / 1000 ;
    int min = sec / 60 ;	//分钟
    sec = sec % 60 ;		//秒
    if(min < 10){	//分钟补0
      if(sec < 10){	//秒补0
        return "0"+min+":0"+sec;
      }else{
        return "0"+min+":"+sec;
      }
    }else{
      if(sec < 10){	//秒补0
        return min+":0"+sec;
      }else{
        return min+":"+sec;
      }
    }

  }

  EmoticonClickListener emoticonClickListener = new EmoticonClickListener() {
    @Override
    public void onEmoticonClick(Object o, int actionType, boolean isDelBtn) {

      if (isDelBtn) {
        SimpleCommonUtils.delClick(ekBar.getEtChat());
      } else {
        if(o == null){
          return;
        }
        if(actionType == Constants.EMOTICON_CLICK_BIGIMAGE){
          if(o instanceof EmoticonEntity){
            //OnSendImage(((EmoticonEntity)o).getIconUri());
            OnSendImage(((EmoticonEntity)o).getContent());
          }
        } else {
          String content = null;
          if(o instanceof EmojiBean){
            content = ((EmojiBean)o).emoji;
          } else if(o instanceof EmoticonEntity){
            content = ((EmoticonEntity)o).getContent();
          }

          if(android.text.TextUtils.isEmpty(content)){
            return;
          }
          int index = ekBar.getEtChat().getSelectionStart();
          Editable editable = ekBar.getEtChat().getText();
          editable.insert(index, content);
        }
      }
    }
  };
  private void OnSendImage(String image) {
    if (!android.text.TextUtils.isEmpty(image)) {
      sendMessage(image);
    }
  }

  @Override
  public void OnFuncPop(int height) {

  }

  /*@Override
    public boolean dispatchKeyEvent(KeyEvent event) {
      if(EmoticonsKeyboardUtils.isFullScreen(this)){
        boolean isConsum = ekBar.dispatchKeyEventInFullScreen(event);
        return isConsum ? isConsum : super.dispatchKeyEvent(event);
      }
      return super.dispatchKeyEvent(event);
    }*/
  @Override
  public void OnFuncClose() { }


  //播放录音相关
  private MediaPlayer mediaPlayer;
  private boolean isPlaying=false;
  private void stopPlaySound(){
    if(voicePlayingBgUtil!=null){
      voicePlayingBgUtil.stopPlay();
    }
    if(mediaPlayer !=null){
      mediaPlayer.stop();
      mediaPlayer.release();
      mediaPlayer=null;
    }
  }
  private void startPlaySound(String voicePath){
    stopPlaySound();
    mediaPlayer = new MediaPlayer();
    mediaPlayer.setOnCompletionListener(this);
    mediaPlayer.setOnErrorListener(this);
    mediaPlayer.setOnBufferingUpdateListener(this);
    mediaPlayer.setOnPreparedListener(this);
    mediaPlayer.setOnVideoSizeChangedListener(this);
    try {
      mediaPlayer.setDataSource(voicePath);
      mediaPlayer.setOnPreparedListener(this);
      mediaPlayer.prepareAsync();
    } catch (IllegalStateException e) {
      e.printStackTrace();
    } catch (IOException e) {
      e.printStackTrace();
    }

  }
  @Override
  public void onPrepared(MediaPlayer mp){
    //  当完成prepareAsync方法时，将调用活动的onPrepared方法
    mediaPlayer.start();
  }
  @Override
  public void onBufferingUpdate(MediaPlayer mp, int percent){
//      当MediaPlayer正在缓冲时，将调用活动的onBufferingUpdate方法
  }
  @Override
  public void onCompletion(MediaPlayer mp){
    isPlaying=false;
    if(voicePlayingBgUtil!=null){
      voicePlayingBgUtil.stopPlay();
    }
  }


  @Override
  public boolean onError(MediaPlayer mp, int what, int extra) {
    isPlaying=false;
    if(voicePlayingBgUtil!=null){
      voicePlayingBgUtil.stopPlay();
    }
    return false;
  }

  @Override
  public void onVideoSizeChanged(MediaPlayer mp, int width, int height) {

  }


}