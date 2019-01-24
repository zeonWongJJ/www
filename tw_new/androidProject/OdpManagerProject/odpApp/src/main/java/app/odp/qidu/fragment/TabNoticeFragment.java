package app.odp.qidu.fragment;

import android.os.Build;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import com.anthony.rvhelper.adapter.MultiItemTypeAdapter;
import com.anthony.rvhelper.divider.DividerItemDecoration;
import com.app.base.bean.Notice;
import com.app.base.netUtil.NoticeHttpUtil;
import com.app.base.utils.CommonKey;
import com.common.lib.base.BaseLazyFragment;
import com.common.lib.utils.StatusBarUtil;
import com.luck.picture.lib.immersive.LightStatusBarUtils;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import app.odp.qidu.R;
import app.odp.qidu.adapter.NoticeListAdapter;
import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;

/**
 * 通知
 */

public class TabNoticeFragment extends BaseLazyFragment{
    private String param;
    protected RecyclerView mRecyclerView;
    private NoticeListAdapter adapter;
    public static TabNoticeFragment getInstance(String param) {
        TabNoticeFragment sf = new TabNoticeFragment();
        sf.param = param;
        return sf;
    }

    @Override
    protected void onVisible() {
        StatusBarUtil.setStatusBarColor(getActivity(),R.color.white);
        LightStatusBarUtils.setLightStatusBar(getActivity(),true);
    }

    @Nullable
    @Override
    public View onCreateView(LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        return inflater.inflate(R.layout.fragment_tab_notice,container,false);
    }

    @Override
    public void onViewCreated(View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);
        View layout_parent=view.findViewById(R.id.layout_parent);
        layout_parent.setBackgroundColor(getResources().getColor(R.color.white));
        TextView titleCenter=view.findViewById(R.id.title_center_text);
        titleCenter.setTextColor(getActivity().getResources().getColor(R.color.black));
        titleCenter.setText("通知");
        ImageView back=view.findViewById(R.id.title_left_image);
        back.setImageResource(R.drawable.icon_back_black);
        back.setOnClickListener(v -> {
            getActivity().finish();
        });
        mRecyclerView=view.findViewById(R.id.recycler);
        adapter = new NoticeListAdapter(getActivity());
        DividerItemDecoration decoration=new DividerItemDecoration(getActivity(), LinearLayoutManager.VERTICAL,R.drawable.list_divider_default);
        decoration.showLastFootViewDivider(false);
        mRecyclerView.addItemDecoration(decoration);
        mRecyclerView.setLayoutManager(new LinearLayoutManager(getActivity()));

        mRecyclerView.setAdapter(adapter);
        List<Notice> list=new ArrayList<>();
        Notice noticeSystem=new Notice();
        noticeSystem.setMsgType(CommonKey.KEY_NOTICE_SYSTEM);
        noticeSystem.setTitle("系统通知");
        noticeSystem.setBulletin_content("你有新的消息未查看，请及时查看");
        list.add(noticeSystem);

        Notice noticePublic=new Notice();
        noticePublic.setMsgType(CommonKey.KEY_NOTICE_PUBLIC);
        noticePublic.setTitle("公告通知");
        noticePublic.setBulletin_content("你有新的消息未查看，请及时查看");
        list.add(noticePublic);

        Notice noticeApproval=new Notice();
        noticeApproval.setMsgType(CommonKey.KEY_NOTICE_APPROVAL);
        noticeApproval.setTitle("审批通知");
        noticeApproval.setBulletin_content("你有新的消息未查看，请及时查看");
        list.add(noticeApproval);
        adapter.refreshData(list);


    }


    @Override
    public void onResume() {
        super.onResume();
        initPublicNoticeUnRead();
    }

    //获取当前登录用户未读的通知公告总数
    private void initPublicNoticeUnRead(){
        HashMap<String, String> hashMap=new HashMap<>();
        Disposable disposable= NoticeHttpUtil.getInstance().initPublicNoticeUnRead(hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String data) {
                try {
                    JSONObject object=new JSONObject(data);
                    String str=object.getString("list");
                    if(str!=null&&!str.equals("null")) {
                        JSONObject jsonObject=object.getJSONObject("list");
                        if (jsonObject!=null) {
                            String count = jsonObject.getString("count");
                            for (int i = 0; i < adapter.getDatas().size(); i++) {
                                if (adapter.getDatas().get(i).getMsgType().equals(CommonKey.KEY_NOTICE_PUBLIC)) {
                                    adapter.getDatas().get(i).setUnReadCount(count);
                                    adapter.notifyItemChanged(i);
                                }
                            }
                        }
                    }
                } catch (JSONException e) {
                    e.printStackTrace();
                }

            }
            @Override
            public void onError(Throwable e) {

            }
            @Override
            public void onComplete() {

            }
        },String.class);

    }
}
