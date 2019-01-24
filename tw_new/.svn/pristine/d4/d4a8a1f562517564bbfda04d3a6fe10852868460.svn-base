package com.qidu.chat.fragment.sidebar;

import android.content.Context;
import android.content.SharedPreferences;
import android.support.annotation.NonNull;
import android.support.v4.util.Pair;
import android.util.Log;

import com.qidu.chat.RocketChatApplication;
import com.qidu.chat.RocketChatCache;
import com.qidu.chat.api.MethodCallHelper;
import com.qidu.chat.helper.AbsoluteUrlHelper;
import com.qidu.chat.helper.LogIfError;
import com.qidu.chat.helper.Logger;
import com.qidu.chat.helper.TextUtils;

import java.util.ArrayList;
import java.util.List;

import com.qidu.chat.BackgroundLooper;
import com.qidu.chat.shared.BasePresenter;
import chat.rocket.core.interactors.RoomInteractor;
import chat.rocket.core.models.Room;
import chat.rocket.core.models.RoomSidebar;
import chat.rocket.core.models.Spotlight;
import chat.rocket.core.models.User;
import chat.rocket.core.repositories.SpotlightRepository;
import chat.rocket.core.repositories.UserRepository;
import chat.rocket.core.utils.CommonKey;
import chat.rocket.persistence.realm.repositories.RealmSpotlightRepository;
import io.reactivex.Flowable;
import io.reactivex.android.schedulers.AndroidSchedulers;
import io.reactivex.disposables.Disposable;

public class SidebarMainPresenter extends BasePresenter<SidebarMainContract.View> implements SidebarMainContract.Presenter {
    private final String hostname;
    private final RoomInteractor roomInteractor;
    private final UserRepository userRepository;
    private final RocketChatCache rocketChatCache;
    private final AbsoluteUrlHelper absoluteUrlHelper;
    private final MethodCallHelper methodCallHelper;
    private SpotlightRepository realmSpotlightRepository;
    private List<RoomSidebar> roomSidebarList;

    public SidebarMainPresenter(String hostname,
                                RoomInteractor roomInteractor,
                                UserRepository userRepository,
                                RocketChatCache rocketChatCache,
                                AbsoluteUrlHelper absoluteUrlHelper,
                                MethodCallHelper methodCallHelper,
                                RealmSpotlightRepository realmSpotlightRepository) {
        this.hostname = hostname;
        this.roomInteractor = roomInteractor;
        this.userRepository = userRepository;
        this.rocketChatCache = rocketChatCache;
        this.absoluteUrlHelper = absoluteUrlHelper;
        this.methodCallHelper = methodCallHelper;
        this.realmSpotlightRepository = realmSpotlightRepository;
    }

    @Override
    public void bindView(@NonNull SidebarMainContract.View view) {
        super.bindView(view);

        if (TextUtils.isEmpty(hostname)) {
            view.showEmptyScreen();
            return;
        }

        view.showScreen();
        SharedPreferences sp = RocketChatApplication.getInstance().getSharedPreferences(CommonKey.KEY_LOGIN_USER_ID, Context.MODE_PRIVATE);
        String localUserId = sp.getString("user_id", null);
        if(localUserId!=null){
            subscribeToRooms();
        }
        //subscribeToRooms();

        final Disposable subscription = Flowable.combineLatest(
                userRepository.getCurrent().distinctUntilChanged(),
                absoluteUrlHelper.getRocketChatAbsoluteUrl().toFlowable(),
                Pair::new
        )
                .subscribeOn(AndroidSchedulers.from(BackgroundLooper.get()))
                .observeOn(AndroidSchedulers.mainThread())
                .subscribe(pair -> view.show(pair.first.orNull()), Logger::report);
                /*.subscribe(
                        pair -> {
                            if(pair.first!=null){
                                subscribeToRooms();

                            }
                            view.show(pair.first.orNull());
                        },
                        throwable -> {
                            Logger.report(throwable);
                        }
                );*/

        addSubscription(subscription);
    }

    @Override
    public void onRoomSelected(RoomSidebar roomSidebar) {
        if(roomSidebar.getType().equals(Room.TYPE_CHANNEL)){
            rocketChatCache.setSelectedRoomDirectMessageType(Room.TYPE_CHANNEL);//暂时是当Room.TYPE_CHANNEL为群聊
        }else if(roomSidebar.getType().equals(Room.TYPE_DIRECT_MESSAGE)){
            rocketChatCache.setSelectedRoomDirectMessageType(Room.TYPE_DIRECT_MESSAGE);
        }
        rocketChatCache.setSelectedRoomId(roomSidebar.getRoomId());
    }

    @Override
    public Flowable<List<Spotlight>> searchSpotlight(String term) {
        methodCallHelper.searchSpotlight(term);
        return realmSpotlightRepository.getSuggestionsFor(term, 10);
    }

    @Override
    public void onSpotlightSelected(Spotlight spotlight) {
        if (spotlight.getType().equals(Room.TYPE_DIRECT_MESSAGE)) {//单聊
            String username = spotlight.getName();

            methodCallHelper.createDirectMessage(username)
                    .continueWithTask(task -> {
                        if (task.isCompleted()) {
                            rocketChatCache.setSelectedRoomDirectMessageType(Room.TYPE_DIRECT_MESSAGE);
                            rocketChatCache.setSelectedRoomId(task.getResult());
                        }
                        return null;
                    });
        } else {//群聊
            methodCallHelper.joinRoom(spotlight.getId())
                    .continueWithTask(task -> {
                        if (task.isCompleted()) {
                            rocketChatCache.setSelectedRoomDirectMessageType(Room.TYPE_CHANNEL);//暂时是当Room.TYPE_CHANNEL为群聊
                            rocketChatCache.setSelectedRoomId(spotlight.getId());
                        }
                        return null;
                    });
        }
    }



    @Override
    public void disposeSubscriptions() {
        clearSubscriptions();
    }

    private void subscribeToRooms() {
        final Disposable subscription = roomInteractor.getOpenRooms()
                .distinctUntilChanged()
                .subscribeOn(AndroidSchedulers.from(BackgroundLooper.get()))
                .observeOn(AndroidSchedulers.mainThread())
                .subscribe(this::processRooms, Logger::report);
        addSubscription(subscription);
    }

    private void processRooms(List<Room> roomList) {

        roomSidebarList = new ArrayList<>();
        List<String> userToObserverList = new ArrayList<>();

        for (Room room : roomList) {
            String roomName = room.getName();
            String roomType = room.getType();

            RoomSidebar roomSidebar = new RoomSidebar();

            roomSidebar.setId(room.getId());
            roomSidebar.setRoomId(room.getRoomId());
            roomSidebar.setRoomName(roomName);
            roomSidebar.setType(roomType);
            roomSidebar.setAlert(room.isAlert());
            roomSidebar.setFavorite(room.isFavorite());
            roomSidebar.setUnread(room.getUnread());
            roomSidebar.setUpdateAt(room.getUpdatedAt());
            roomSidebar.setLastSeen(room.getLastSeen());

            if (roomType.equals(Room.TYPE_DIRECT_MESSAGE)) {
                userToObserverList.add(roomName);
            }

            roomSidebarList.add(roomSidebar);
        }
        if (userToObserverList.isEmpty()) {
            view.showRoomSidebarList(roomSidebarList);
        } else {
            getUsersStatus();
        }
    }

    private void getUsersStatus() {
        // TODO Filter when Android Studion uses the java8 features (removeIf).
        // .filter(userList -> userList.removeIf(user -> !userToObserverList.contains(user.getUsername())))
        final Disposable subscription = userRepository.getAll()
                .distinctUntilChanged()
                .subscribeOn(AndroidSchedulers.from(BackgroundLooper.get()))
                .observeOn(AndroidSchedulers.mainThread())
                .subscribe(this::processUsers, Logger::report);
        addSubscription(subscription);
  }

    private void processUsers(List<User> userList) {
        for (User user: userList) {
            for(RoomSidebar roomSidebar: roomSidebarList) {
                if (roomSidebar.getRoomName().equals(user.getUsername())) {
                    roomSidebar.setUserStatus(user.getStatus());
                }
            }
        }
        view.showRoomSidebarList(roomSidebarList);
    }


}