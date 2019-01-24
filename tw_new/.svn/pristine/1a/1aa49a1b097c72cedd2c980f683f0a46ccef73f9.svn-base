package com.qidu.chat.layouthelper.chatroom;

import android.content.Context;
import android.content.SharedPreferences;
import android.support.v4.app.FragmentActivity;
import android.support.v4.util.Pair;
import android.support.v7.util.DiffUtil;
import android.util.Log;
import android.view.View;

import com.qidu.chat.BackgroundLooper;
import com.qidu.chat.helper.Logger;
import com.qidu.chat.helper.TextUtils;
import com.qidu.chat.layouthelper.ExtModelListAdapter;

import java.util.ArrayList;
import java.util.Collections;
import java.util.List;
import com.qidu.chat.R;

import org.json.JSONObject;

import chat.rocket.android.widget.AbsoluteUrl;
import chat.rocket.core.models.Message;
import chat.rocket.core.utils.CommonKey;
import chat.rocket.persistence.realm.repositories.RealmMessageRepository;
import io.reactivex.Single;
import io.reactivex.SingleEmitter;
import io.reactivex.SingleOnSubscribe;
import io.reactivex.android.schedulers.AndroidSchedulers;
import io.reactivex.annotations.NonNull;
import io.reactivex.disposables.Disposable;
import io.reactivex.functions.Consumer;

/**
 * target list adapter for chat room.
 */
public class MessageListAdapter extends ExtModelListAdapter<Message, PairedMessage, AbstractMessageViewHolder> {

  private static final int VIEW_TYPE_UNKNOWN = 0;
  private static final int VIEW_TYPE_NORMAL_MESSAGE = 1;
  private static final int VIEW_TYPE_SYSTEM_MESSAGE = 2;

  private static final int VIEW_TYPE_SELF_MESSAGE = 3;//用户自己的布局
  private String hostname;
  private AbsoluteUrl absoluteUrl;

  private boolean autoloadImages = true;//默认显示图片
  private boolean hasNext;
  private boolean isLoaded;
  private FragmentActivity activity;
  private String localUserId=null;//用户登录的id
  private RealmMessageRepository realmMessageRepository;

  public MessageListAdapter(FragmentActivity activity, String hostname) {
    super(activity);
    this.activity=activity;
    this.hostname = hostname;
    this.hasNext = true;
    realmMessageRepository=new RealmMessageRepository(hostname);
  }
  private View.OnClickListener audioClickListener;
  public void setAudioClickListener(View.OnClickListener audioClickListener){
    this.audioClickListener=audioClickListener;
  }

  public void setAbsoluteUrl(AbsoluteUrl absoluteUrl) {
    this.absoluteUrl = absoluteUrl;
    notifyDataSetChanged();
  }

  public void setAutoloadImages(boolean autoloadImages) {
    this.autoloadImages = autoloadImages;
  }

  /**
   * update Footer state considering hasNext and isLoaded.
   */
  public void updateFooter(boolean hasNext, boolean isLoaded) {
    this.hasNext = hasNext;
    this.isLoaded = isLoaded;
    notifyFooterChanged();
  }

  @Override
  protected int getHeaderLayout() {
    return R.layout.list_item_message_header;
  }

  @Override
  protected int getFooterLayout() {
    if (!hasNext || isLoaded) {
      return R.layout.list_item_message_start_of_conversation;
    } else {
      return R.layout.list_item_message_loading;
    }
  }

  @Override
  protected int getRealmModelViewType(PairedMessage model) {
    if (model.target != null) {
      //Log.i("llll","类型"+model.target.getType()+"====="+localUserId);
      if(localUserId==null){
        SharedPreferences sp = activity.getSharedPreferences(CommonKey.KEY_LOGIN_USER_ID, Context.MODE_PRIVATE);
        localUserId = sp.getString("user_id", null);
      }
      if(localUserId!=null&&localUserId.equals(model.target.getUser().getId())){
        return  VIEW_TYPE_SELF_MESSAGE;
      }else {
        if (TextUtils.isEmpty(model.target.getType())) {
          return VIEW_TYPE_NORMAL_MESSAGE;
        } else {
          return VIEW_TYPE_SYSTEM_MESSAGE;
        }
      }
    }
    return VIEW_TYPE_UNKNOWN;
  }

  @Override
  protected int getRealmModelLayout(int viewType) {
    switch (viewType) {
      case VIEW_TYPE_NORMAL_MESSAGE:
        return R.layout.list_item_normal_message;
      case VIEW_TYPE_SYSTEM_MESSAGE:
        return R.layout.list_item_system_message;
      case VIEW_TYPE_SELF_MESSAGE://用户自己的布局
        return R.layout.list_item_self_message;
      default:
        return R.layout.simple_screen;
    }
  }

  @Override
  protected AbstractMessageViewHolder onCreateRealmModelViewHolder(int viewType, View itemView) {
    switch (viewType) {
      case VIEW_TYPE_NORMAL_MESSAGE:
        return new MessageNormalViewHolder(activity,itemView, absoluteUrl, hostname,false,audioClickListener);
      case VIEW_TYPE_SELF_MESSAGE:
        return new MessageNormalViewHolder(activity,itemView, absoluteUrl, hostname,true,audioClickListener);
      case VIEW_TYPE_SYSTEM_MESSAGE:
        return new MessageSystemViewHolder(activity,itemView, absoluteUrl, hostname);
      default:
        return new AbstractMessageViewHolder(itemView, absoluteUrl, hostname) {
          @Override
          protected void bindMessage(PairedMessage pairedMessage, int position, boolean autoloadImages) {

          }
        };
    }
  }

  public void updateRedPacketStatues(String messageId,int position){
    Log.i("bbbbb",messageId+"---messageId");
    Disposable disposable = realmMessageRepository.getById(messageId)
            .flatMap(it -> {
              if (!it.isPresent()) {
                return Single.just(Pair.<Message, Boolean>create(null, false));
              }
              Message message = it.get();
              String messageBody=message.getMessage().replace("bot:FHB:","");
              JSONObject object=new JSONObject(messageBody);
              object.put("receiveState","yes");
              Message messageNew = Message.builder()
                      .setId(message.getId())
                      .setSyncState(message.getSyncState())
                      .setTimestamp(message.getTimestamp())
                      .setRoomId(message.getRoomId())
                      .setMessage("bot:FHB:"+object.toString())
                      .setGroupable(false)
                      .setUser(message.getUser())
                      .setEditedAt(message.getEditedAt())
                      .build();
              //message.withMessage("bot:FHB:"+object.toString());
              //realmMessageRepository.save(messageNew);

              return Single.zip(
                      Single.just(messageNew),
                      realmMessageRepository.save(messageNew),
                      Pair::create
              );
            }).subscribeOn(AndroidSchedulers.from(BackgroundLooper.get()))
            .observeOn(AndroidSchedulers.mainThread())
            .subscribe(
                    pair -> {
                      if (pair.second) {
                        MessageListAdapter.this.notifyDataSetChanged();
                      }else {
                        //Log.i("bbbbb","失败"+pair.first.getMessage()+"");
                      }
                    },
                    throwable -> {
                      Logger.report(throwable);
                    }
            );
    //compositeDisposable.add(disposable);
    //Message message=getItem();

  }
  @Override
  protected List<PairedMessage> mapResultsToViewModel(List<Message> results) {
    if (results.isEmpty()) {
      return Collections.emptyList();
    }

    ArrayList<PairedMessage> extMessages = new ArrayList<>();
    for (int i = 0; i < results.size() - 1; i++) {
      extMessages.add(new PairedMessage(results.get(i), results.get(i + 1)));
    }
    extMessages.add(new PairedMessage(results.get(results.size() - 1), null));

    return extMessages;
  }

  @Override
  protected boolean shouldAutoloadImages() {
    return autoloadImages;
  }

  @Override
  protected DiffUtil.Callback getDiffCallback(List<PairedMessage> oldData,
                                              List<PairedMessage> newData) {
    return new PairedMessageDiffCallback(oldData, newData);
  }

  private static class PairedMessageDiffCallback extends DiffUtil.Callback {

    private final List<PairedMessage> oldList;
    private final List<PairedMessage> newList;

    public PairedMessageDiffCallback(List<PairedMessage> oldList, List<PairedMessage> newList) {
      this.oldList = oldList;
      this.newList = newList;
    }

    @Override
    public int getOldListSize() {
      if (oldList == null) {
        return 0;
      }
      return oldList.size();
    }

    @Override
    public int getNewListSize() {
      if (newList == null) {
        return 0;
      }
      return newList.size();
    }

    @Override
    public boolean areItemsTheSame(int oldItemPosition, int newItemPosition) {
      PairedMessage oldMessage = oldList.get(oldItemPosition);
      PairedMessage newMessage = newList.get(newItemPosition);

      return oldMessage.getId().equals(newMessage.getId());
    }

    @Override
    public boolean areContentsTheSame(int oldItemPosition, int newItemPosition) {
      PairedMessage oldMessage = oldList.get(oldItemPosition);
      PairedMessage newMessage = newList.get(newItemPosition);

      return oldMessage.equals(newMessage);
    }
  }
}