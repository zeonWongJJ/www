package com.qidu.chat.fragment.chatroom;

import android.content.Context;
import android.content.SharedPreferences;
import android.support.annotation.NonNull;
import android.support.annotation.Nullable;
import android.support.v4.util.Pair;
import android.util.Log;

import com.hadisatrio.optional.Optional;
import com.qidu.chat.helper.AbsoluteUrlHelper;
import com.qidu.chat.helper.LogIfError;

import org.json.JSONArray;

import bolts.Continuation;
import bolts.Task;
import chat.rocket.core.utils.CommonKey;
import io.reactivex.Single;
import io.reactivex.android.schedulers.AndroidSchedulers;
import io.reactivex.disposables.Disposable;

import com.qidu.chat.BackgroundLooper;
import com.qidu.chat.api.MethodCallHelper;
import com.qidu.chat.helper.Logger;
import com.qidu.chat.shared.BasePresenter;
import chat.rocket.core.SyncState;
import chat.rocket.core.interactors.MessageInteractor;
import chat.rocket.core.models.Message;
import chat.rocket.core.models.Room;
import chat.rocket.core.models.Settings;
import chat.rocket.core.models.User;
import chat.rocket.core.repositories.RoomRepository;
import chat.rocket.core.repositories.UserRepository;
import io.reactivex.functions.Consumer;

import com.qidu.chat.service.ConnectivityManagerApi;

import static android.content.Context.MODE_PRIVATE;

public class RoomPresenter extends BasePresenter<RoomContract.View>
    implements RoomContract.Presenter {

  private final String roomId;
  private final MessageInteractor messageInteractor;
  private final UserRepository userRepository;
  private final RoomRepository roomRepository;
  private final AbsoluteUrlHelper absoluteUrlHelper;
  private final MethodCallHelper methodCallHelper;
  private final ConnectivityManagerApi connectivityManagerApi;
  private Room currentRoom;
  public RoomPresenter(String roomId,
                       UserRepository userRepository,
                       MessageInteractor messageInteractor,
                       RoomRepository roomRepository,
                       AbsoluteUrlHelper absoluteUrlHelper,
                       MethodCallHelper methodCallHelper,
                       ConnectivityManagerApi connectivityManagerApi) {
    this.roomId = roomId;
    this.userRepository = userRepository;
    this.messageInteractor = messageInteractor;
    this.roomRepository = roomRepository;
    this.absoluteUrlHelper = absoluteUrlHelper;
    this.methodCallHelper = methodCallHelper;
    this.connectivityManagerApi = connectivityManagerApi;
  }

  @Override
  public void bindView(@NonNull RoomContract.View view) {
    super.bindView(view);
    refreshRoom();
  }

  @Override
  public void refreshRoom() {
    getAbsoluteUrl();
    getRoomRoles();
    getRoomInfo();
    getRoomHistoryStateInfo();
    //getMessages();
    getUserPreferences();
    //getAbsoluteUrl();
  }


  @Override
  public void loadMessages() {
    final Disposable subscription = getSingleRoom()
        .flatMap(messageInteractor::loadMessages)
        .subscribeOn(AndroidSchedulers.from(BackgroundLooper.get()))
        .observeOn(AndroidSchedulers.mainThread())
        .subscribe(
            success -> {
              if (success) {
                connectivityManagerApi.keepAliveServer();
              }
            },
            Logger::report
        );

    addSubscription(subscription);
  }

  @Override
  public void loadListEmojiCustom(Context context) {
    Task<JSONArray> task=methodCallHelper.listEmojiCustom();
    task.onSuccessTask(new Continuation<JSONArray, Task<JSONArray>>() {
      public Task<JSONArray> then(Task<JSONArray> task) {
        SharedPreferences pref = context.getSharedPreferences(CommonKey.KEY_CUSTOM_LIST_EMOJI,MODE_PRIVATE);
        SharedPreferences.Editor editor = pref.edit();
        editor.putString("listEmojiCustom",task.getResult().toString());
        editor.commit();
        return Task.forResult(task.getResult());
      }
    });
  }

  @Override
  public void loadMoreMessages() {

    final Disposable subscription = getSingleRoom()
        .flatMap(messageInteractor::loadMoreMessages)
        .subscribeOn(AndroidSchedulers.from(BackgroundLooper.get()))
        .observeOn(AndroidSchedulers.mainThread())
        .subscribe(
            success -> {
              if (success) {
                connectivityManagerApi.keepAliveServer();
              }
            },
            Logger::report
        );

    addSubscription(subscription);
  }

  @Override
  public void onMessageSelected(@Nullable Message message) {
    if (message == null) {
      return;
    }
    Log.i("bbbbb",message.getSyncState()+"message.getType====="+message.getType());
    if (message.getType() == null && message.getSyncState() == SyncState.SYNCED) {
      // If message is not a system message show applicable actions.
      view.showMessageActions(message);
    }
  }

  @Override
  public void onMessageTap(@Nullable Message message) {
    if (message == null) {
      return;
    }

    if (message.getSyncState() == SyncState.FAILED) {
      view.showMessageSendFailure(message);
    }
  }

  @Override
  public void replyMessage(@NonNull Message message, boolean justQuote) {
    this.absoluteUrlHelper.getRocketChatAbsoluteUrl()
            .cache()
            .subscribeOn(AndroidSchedulers.from(BackgroundLooper.get()))
            .observeOn(AndroidSchedulers.mainThread())
            .subscribe(
                    serverUrl -> {
                      if (serverUrl.isPresent()) {
                        RocketChatAbsoluteUrl absoluteUrl = serverUrl.get();
                        String baseUrl = absoluteUrl.getBaseUrl();
                        view.onReply(absoluteUrl, buildReplyOrQuoteMarkdown(baseUrl, message, justQuote), message);
                      }
                    },
                    Logger::report
            );
  }

  private String buildReplyOrQuoteMarkdown(String baseUrl, Message message, boolean justQuote) {
    if (currentRoom == null || message.getUser() == null) {
      return "";
    }

    if (currentRoom.isDirectMessage()) {
      return String.format("[ ](%s/direct/%s?msg=%s) ", baseUrl,
              message.getUser().getUsername(),
              message.getId());
    } else {
      return String.format("[ ](%s/channel/%s?msg=%s) %s", baseUrl,
              currentRoom.getName(),
              message.getId(),
              justQuote ? "" : "@" + message.getUser().getUsername() + " ");
    }
  }

  @Override
  public void sendMessage(String messageText) {

    //view.disableMessageInput();
    final Disposable subscription = getRoomUserPair()
            .flatMap(pair -> messageInteractor.send(pair.first, pair.second, messageText))
            .subscribeOn(AndroidSchedulers.from(BackgroundLooper.get()))
            .observeOn(AndroidSchedulers.mainThread())
            .subscribe(
                    success -> {
                      if (success) {
                        view.onMessageSendSuccessfully();
                      }
                      view.enableMessageInput();
                    },
                    throwable -> {
                      view.enableMessageInput();
                      Logger.report(throwable);
                    }
            );

    addSubscription(subscription);
  }

  @Override
  public void resendMessage(Message message) {
    final Disposable subscription = getCurrentUser()
        .flatMap(user -> messageInteractor.resend(message, user))
        .subscribeOn(AndroidSchedulers.from(BackgroundLooper.get()))
        .observeOn(AndroidSchedulers.mainThread())
        .subscribe();

    addSubscription(subscription);
  }

  @Override
  public void updateMessage(Message message, String content) {
    view.disableMessageInput();
    final Disposable subscription = getCurrentUser()
            .flatMap(user -> messageInteractor.update(message, user, content))
            .subscribeOn(AndroidSchedulers.from(BackgroundLooper.get()))
            .observeOn(AndroidSchedulers.mainThread())
            .subscribe(
                    success -> {
                      if (success) {
                        view.onMessageSendSuccessfully();
                      }
                      view.enableMessageInput();
                    },
                    throwable -> {
                      view.enableMessageInput();
                      Logger.report(throwable);
                    }
            );

    addSubscription(subscription);
  }

  @Override
  public void deleteMessage(Message message) {
    final Disposable subscription = messageInteractor.delete(message)
        .subscribeOn(AndroidSchedulers.from(BackgroundLooper.get()))
        .observeOn(AndroidSchedulers.mainThread())
        .subscribe();

    addSubscription(subscription);
  }

  @Override
  public void onUnreadCount() {
    final Disposable subscription = getRoomUserPair()
        .flatMap(roomUserPair -> messageInteractor
            .unreadCountFor(roomUserPair.first, roomUserPair.second))
        .subscribeOn(AndroidSchedulers.from(BackgroundLooper.get()))
        .observeOn(AndroidSchedulers.mainThread())
        .subscribe(
            count -> view.showUnreadCount(count),
            Logger::report
        );

    addSubscription(subscription);
  }

  @Override
  public void onMarkAsRead() {
    final Disposable subscription = roomRepository.getById(roomId)
        .filter(Optional::isPresent)
        .map(Optional::get)
        .firstElement()
        .filter(Room::isAlert)
        .subscribeOn(AndroidSchedulers.from(BackgroundLooper.get()))
        .observeOn(AndroidSchedulers.mainThread())
        .subscribe(
            room -> methodCallHelper.readMessages(room.getRoomId())
                .continueWith(new LogIfError()),
            Logger::report
        );

    addSubscription(subscription);
  }

  private void getRoomRoles() {
    methodCallHelper.getRoomRoles(roomId);
  }

  private void getRoomInfo() {
    final Disposable subscription = roomRepository.getById(roomId)
            .distinctUntilChanged()
            .filter(Optional::isPresent)
            .map(Optional::get)
            .subscribeOn(AndroidSchedulers.from(BackgroundLooper.get()))
            .observeOn(AndroidSchedulers.mainThread())
            .subscribe(this::processRoom, Logger::report);
    addSubscription(subscription);
  }

  private void processRoom(Room room) {
    this.currentRoom = room;
    view.render(room);

    if (room.isDirectMessage()) {
      getUserByUsername(room.getName());
    }
  }

  private void getUserByUsername(String username) {
    final Disposable disposable = userRepository.getByUsername(username)
            .distinctUntilChanged()
            .filter(Optional::isPresent)
            .map(Optional::get)
            .subscribeOn(AndroidSchedulers.from(BackgroundLooper.get()))
            .observeOn(AndroidSchedulers.mainThread())
            .subscribe(view::showUserStatus, Logger::report);
    addSubscription(disposable);
  }

  private void getRoomHistoryStateInfo() {
    final Disposable subscription = roomRepository.getHistoryStateByRoomId(roomId)
        .distinctUntilChanged()
        .filter(Optional::isPresent)
        .map(Optional::get)
        .subscribeOn(AndroidSchedulers.from(BackgroundLooper.get()))
        .observeOn(AndroidSchedulers.mainThread())
        .subscribe(
            roomHistoryState -> {
              int syncState = roomHistoryState.getSyncState();
              view.updateHistoryState(
                  !roomHistoryState.isComplete(),
                  syncState == SyncState.SYNCED || syncState == SyncState.FAILED
              );
            },
            Logger::report
        );

    addSubscription(subscription);
  }

  private void getMessages() {
    final Disposable subscription = roomRepository.getById(roomId)
        .filter(Optional::isPresent)
        .map(Optional::get)
        .flatMap(messageInteractor::getAllFrom)
        .subscribeOn(AndroidSchedulers.from(BackgroundLooper.get()))
        .observeOn(AndroidSchedulers.mainThread())
        .subscribe(
            messages -> view.showMessages(messages),
            Logger::report
        );

    addSubscription(subscription);
  }

  private void getUserPreferences() {
    final Disposable subscription = userRepository.getCurrent()
        .filter(Optional::isPresent)
        .map(Optional::get)
        .filter(user -> user.getSettings() != null)
        .map(User::getSettings)
        .filter(settings -> settings.getPreferences() != null)
        .map(Settings::getPreferences)
        .distinctUntilChanged()
        .subscribeOn(AndroidSchedulers.from(BackgroundLooper.get()))
        .observeOn(AndroidSchedulers.mainThread())
        .subscribe(
            preferences -> {
              if (preferences.isAutoImageLoad()) {
                view.autoloadImages();
              } else {
                view.manualLoadImages();
              }
            },
            Logger::report
        );

    addSubscription(subscription);
  }

  public void getAbsoluteUrl() {
    final Disposable subscription = absoluteUrlHelper.getRocketChatAbsoluteUrl()
        .subscribeOn(AndroidSchedulers.from(BackgroundLooper.get()))
        .observeOn(AndroidSchedulers.mainThread())
        /*.subscribe(
            it -> view.setupWith(it.orNull()),
            Logger::report
        );*/
        .subscribe(new Consumer<Optional<RocketChatAbsoluteUrl>>() {
          @Override
          public void accept(Optional<RocketChatAbsoluteUrl> rocketChatAbsoluteUrlOptional) throws Exception {
            view.setupWith(rocketChatAbsoluteUrlOptional.orNull());
            getMessages();
          }
        }, new Consumer<Throwable>() {
          @Override
          public void accept(Throwable throwable) throws Exception {
            Logger.report(throwable);
          }
        });

    addSubscription(subscription);
  }

  private Single<Pair<Room, User>> getRoomUserPair() {
    return Single.zip(
        getSingleRoom(),
        getCurrentUser(),
        Pair::new
    );
  }

  private Single<Room> getSingleRoom() {
    return roomRepository.getById(roomId)
        .filter(Optional::isPresent)
        .map(Optional::get)
        .firstElement()
        .toSingle();
  }

  private Single<User> getCurrentUser() {
    return userRepository.getCurrent()
        .filter(Optional::isPresent)
        .map(Optional::get)
        .firstElement()
        .toSingle();
  }
}
