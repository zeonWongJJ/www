package com.app.base.netUtil;

import android.util.Log;

import com.app.base.bean.BaseResponse;
import com.app.base.bean.MemberRealm;
import com.app.base.bean.Participant;
import com.app.base.bean.UserRealm;
import com.app.base.utils.DataUtils;
import com.app.base.utils.HttpUrl;
import com.app.base.utils.LoginUtil;
import com.google.gson.Gson;
import com.google.gson.reflect.TypeToken;
import com.rx2androidnetworking.Rx2AndroidNetworking;

import java.util.ArrayList;
import java.util.List;
import java.util.Map;

import io.reactivex.Observable;
import io.reactivex.android.schedulers.AndroidSchedulers;
import io.reactivex.disposables.Disposable;
import io.reactivex.functions.Consumer;
import io.reactivex.functions.Function;
import io.reactivex.observers.DisposableObserver;
import io.reactivex.schedulers.Schedulers;

/**
 * Created by 7du-28 on 2018/6/6.
 */

public class MemberHttpUtil {

    private static MemberHttpUtil loginHttpUtil;
    public static MemberHttpUtil getInstance(){
        if(loginHttpUtil==null){
            loginHttpUtil=new MemberHttpUtil();
        }
        return loginHttpUtil;
    }

    public Disposable loginTest(Map<String, String> map, DisposableObserver<MemberRealm> observer, Class clazz){
        Observable<MemberRealm> observable=HttpUtil.getInstance().post(HttpUrl.api_login,map,clazz);
        return observable.subscribeOn(Schedulers.io())
                .observeOn(AndroidSchedulers.mainThread())
                .subscribeWith(observer);
    }

    public Disposable login(Map<String, String> map, DisposableObserver<MemberRealm> observer, Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_login,map,observer,clazz);
    }

    //各部门人员列表
    public Disposable departmentAndMembers(final Map<String, String> map, DisposableObserver<List<Participant>> observer){
        Observable<List<UserRealm>> observable=HttpUtil.getInstance().post(HttpUrl.api_department_and_member,map,UserRealm.class);
        return observable.map(new Function<List<UserRealm>, List<Participant>>() {
            @Override
            public List<Participant> apply(List<UserRealm> userRealmList) throws Exception {
                UserRealm.deleteAll();
                //保存数据
                UserRealm.insert(userRealmList);
                List<Participant> participantList= DataUtils.getParticipantGroup(userRealmList);
                return participantList;
            }
        }).subscribeOn(Schedulers.io())
                .observeOn(AndroidSchedulers.mainThread())
                .subscribeWith(observer);
    }


    public Disposable signIn(Map<String, String> map, DisposableObserver<String> observer, Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_work_sign_in,map,observer,clazz);
    }

    //获取签到状态
    public Disposable signStatus(Map<String, String> map, DisposableObserver<String> observer, Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_work_sign_status,map,observer,clazz);
    }
    //获取审批人
    public Disposable approvalMember(Map<String, String> map, DisposableObserver<String> observer, Class clazz){
        return HttpUtil.getInstance().post(HttpUrl.api_approval_member,map,observer,clazz);
    }
}
