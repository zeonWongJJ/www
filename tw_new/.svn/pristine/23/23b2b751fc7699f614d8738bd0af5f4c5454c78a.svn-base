package app.odp.qidu.adapter;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.graphics.Rect;
import android.graphics.drawable.BitmapDrawable;
import android.graphics.drawable.ColorDrawable;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.text.SpannableStringBuilder;
import android.text.Spanned;
import android.text.TextPaint;
import android.text.TextUtils;
import android.text.method.LinkMovementMethod;
import android.text.style.ClickableSpan;
import android.text.style.ForegroundColorSpan;
import android.util.Log;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.WindowManager;
import android.view.inputmethod.InputMethodManager;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.PopupWindow;
import android.widget.TextView;
import android.widget.Toast;

import com.anthony.rvhelper.adapter.CommonAdapter;
import com.anthony.rvhelper.base.ViewHolder;
import com.anthony.rvhelper.wrapper.HeaderAndFooterWrapper;
import com.anthony.rvhelper.wrapper.LoadMoreWrapper;
import com.app.base.bean.CommonEventEntity;
import com.app.base.bean.DynamicComment;
import com.app.base.bean.TypeSelect;
import com.app.base.netUtil.HttpUtil;
import com.app.base.utils.CommonKey;
import com.app.base.utils.GlideRoundTransform;
import com.app.base.utils.GsonUtil;
import com.app.base.utils.HttpUrl;
import com.app.base.utils.IntentParams;
import com.app.base.utils.LoginUtil;
import com.app.base.widget.NineGridImageLayout;
import com.app.base.widget.PlanTypeSelectDialog;
import com.app.base.widget.RightAlertDialog;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.bumptech.glide.request.RequestOptions;
import com.common.lib.base.AbsBaseActivity;
import com.common.lib.global.AppUtils;
import com.common.lib.utils.ScreenUtils;
import com.common.lib.utils.StatusBarUtil;
import com.common.lib.utils.ToastUtils;
import com.luck.picture.lib.immersive.LightStatusBarUtils;
import com.luck.picture.lib.rxbus2.RxBus;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import app.odp.qidu.R;
import app.odp.qidu.activity.PublishDynamicActivity;
import io.reactivex.ObservableTransformer;
import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;

//动态
public class DynamicCommentListAdapter extends CommonAdapter<DynamicComment> implements View.OnClickListener {
    private String memberId;
    private RequestOptions options = null;
    private HeaderAndFooterWrapper headerAndFooterWrapper;
    public DynamicCommentListAdapter(final AbsBaseActivity context, RecyclerView recyclerView) {
        super(context, R.layout.layout_dynamic_comment);
        this.activity = context;
        this.inflater = LayoutInflater.from(activity);
        this.recyclerView=recyclerView;
        this.inputManager = (InputMethodManager) activity.getSystemService(Context.INPUT_METHOD_SERVICE);
        options = new RequestOptions()
                .centerCrop()
                .transform(new GlideRoundTransform(mContext))
                .diskCacheStrategy(DiskCacheStrategy.ALL);
        this.memberId=LoginUtil.getInstance().getLoginUser().getMember_id();
        initCommentPop();
    }
    public void addNewComment(DynamicComment comment){//预处理，添加一条新评论在第一条
        mDatas.add(0,comment);
        notifyItemRangeInserted(0,mDatas.size());
    }

    public void setHeaderAndFooterWrapper(HeaderAndFooterWrapper headerAndFooterWrapper){
        this.headerAndFooterWrapper=headerAndFooterWrapper;
    }
    @Override
    protected void convert(ViewHolder holder, final DynamicComment data, int position) {
        if(headerAndFooterWrapper!=null){
            position=position-headerAndFooterWrapper.getHeadersCount();
        }
        int finalPosition = position;
        if(data.getMy_name()!=null){
            holder.setText(R.id.nick_name,data.getMy_name()+"");
        }else {
            holder.setText(R.id.nick_name,"");
        }
        holder.setText(R.id.comment_add_time, data.getAdd_date()+"");
        ImageView userHeader=holder.getView(R.id.user_header);
        //Glide.with(mContext).load("http://img.zcool.cn/community/010f87596f13e6a8012193a363df45.jpg@1280w_1l_2o_100sh.jpg").apply(options).into(userHeader);
        TextView delete_comment=holder.getView(R.id.delete_comment);
        if(data.getMember_id().equals(memberId)){
            delete_comment.setVisibility(View.VISIBLE);
            delete_comment.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    showDeleteDynamicTip(finalPosition);
                }
            });
        }else {
            delete_comment.setVisibility(View.GONE);
        }
        TextView forward_comment=holder.getView(R.id.forward_comment);
        forward_comment.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent=new Intent(mContext,PublishDynamicActivity.class);
                intent.putExtra(IntentParams.KEY_DYNAMIC_TYPE,PublishDynamicActivity.FORWARD_DYNAMIC);
                intent.putExtra(IntentParams.KEY_DYNAMIC_FORWARD_USER,data.getMy_name());
                intent.putExtra(IntentParams.KEY_DYNAMIC_FORWARD_CONTENT,data.getContent());
                intent.putExtra(IntentParams.KEY_DYNAMIC_FORWARD_ID,data.getId());
                mContext.startActivity(intent);
            }
        });
        TextView content=holder.getView(R.id.tv_item_title);
        content.setText(data.getContent()+"");
        TextView link_comment=holder.getView(R.id.link_comment);
        link_comment.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                showCommentPop(CommonKey.KEY_COMMENT_DYNAMIC,v,finalPosition,data);
            }
        });
        TextView like_comment=holder.getView(R.id.like_comment);
        like_comment.setText(data.getLikes()+"");
        if(data.getIs_like()==null){
            like_comment.setCompoundDrawablesWithIntrinsicBounds(0,0,R.drawable.like_unselect,0);
        }else {
            if (data.getIs_like().equals("0")) {
                like_comment.setCompoundDrawablesWithIntrinsicBounds(0, 0, R.drawable.like_unselect, 0);
            } else {
                like_comment.setCompoundDrawablesWithIntrinsicBounds(0, 0, R.drawable.like_select, 0);
            }
        }
        like_comment.setOnClickListener(v -> {
            likeDynamicComment(finalPosition);
        });

        TextView iv_details=holder.getView(R.id.iv_details);
        int linesCount=content.getLineCount();
        if (linesCount>3) {
            iv_details.setVisibility(View.VISIBLE);
            iv_details.setOnClickListener(v -> {
                int lineCount=content.getLineCount();
                if (lineCount>3) {
                    content.setEllipsize(TextUtils.TruncateAt.END); // 收缩
                    content.setMaxLines(3);
                    iv_details.setText("全文");
                } else {
                    iv_details.setText("收起");
                    content.setEllipsize(null); // 展开
                    content.setSingleLine(false);
                }
            });
        }else {
            iv_details.setVisibility(View.GONE);
        }
        /*content.setMovementMethod(LinkMovementMethod.getInstance());

        String reply="回复";
        String replyWho=reply+data.getReply_name()+":";
        String all=replyWho+data.getContent();
        SpannableStringBuilder builder=new SpannableStringBuilder(all);
        builder.setSpan(new ForegroundColorSpan(activity.getResources().getColor(R.color.black)), 0, reply.length(), Spanned.SPAN_EXCLUSIVE_EXCLUSIVE);
        builder.setSpan(new ForegroundColorSpan(activity.getResources().getColor(R.color.blue)), reply.length(), replyWho.length(), Spanned.SPAN_EXCLUSIVE_EXCLUSIVE);
        builder.setSpan(new ForegroundColorSpan(activity.getResources().getColor(R.color.black)), replyWho.length()-1, all.length(), Spanned.SPAN_EXCLUSIVE_EXCLUSIVE);
        builder.setSpan(new ClickableSpan() {
            @Override
            public void onClick(View widget) {
                showCommentPop(CommonKey.KEY_COMMENT_DYNAMIC,widget,position,data);
            }
            @Override
            public void updateDrawState(TextPaint ds) {
                ds.setColor(activity.getResources().getColor(R.color.black));
                ds.setUnderlineText(false);
            }
        }, replyWho.length()-1, all.length(), Spanned.SPAN_EXCLUSIVE_EXCLUSIVE);
        content.setText(builder);*/
        View layoutForward=holder.getView(R.id.layout_forward);
        NineGridImageLayout nineGridImageLayout = holder.getView(R.id.layout_nine_grid);
        nineGridImageLayout.setVisibility(View.GONE);
        nineGridImageLayout.setActivityContext(activity);
        nineGridImageLayout.setIsShowAll(true);
        if(data.getForwarded_id()!=null&&!data.getForwarded_id().equals("0")){//如果是转发类型
            layoutForward.setVisibility(View.GONE);
            if(data.getForwarded()!=null) {
                layoutForward.setVisibility(View.VISIBLE);
                holder.setText(R.id.comment_from, "转发自：" + data.getForwarded().getReal_name());
                if (data.getForwarded().getContent() != null) {
                    holder.setText(R.id.comment_from_content, data.getForwarded().getContent() + "");
                }
                if (data.getForwarded().getPic_data() != null) {
                    if (data.getForwarded().getPic_data().size() > 0) {
                        List<String> imgList = data.getForwarded().getPic_data();
                        if (imgList != null) {
                            List<String> imgUrls = new ArrayList<>();
                            for (String url : imgList) {
                                imgUrls.add(HttpUrl.HOST + url);
                            }
                            if (imgList.size() > 0) {
                                nineGridImageLayout.setVisibility(View.VISIBLE);
                                nineGridImageLayout.setUrlList(imgUrls);
                            }
                            nineGridImageLayout.setUrlList(imgUrls);
                        }
                    }
                }
            }
        }else {
            layoutForward.setVisibility(View.GONE);
            List<String> imgList = data.getPic_data();
            if (imgList != null) {
                List<String> imgUrls = new ArrayList<>();
                for (String url : imgList) {
                    imgUrls.add(HttpUrl.HOST + url);
                }
                if(imgList.size()>0){
                    nineGridImageLayout.setVisibility(View.VISIBLE);
                    nineGridImageLayout.setUrlList(imgUrls);
                }
            }
        }
        RecyclerView commentRecyclerView = holder.getView(app.odp.qidu.R.id.comment_recyclerview);
        commentRecyclerView.setLayoutManager(new LinearLayoutManager(mContext));
        final DynamicReplyListAdapter adapter = new DynamicReplyListAdapter(activity, position, listener,longClickListener);
        commentRecyclerView.setAdapter(adapter);
        if(data.getSub()!=null){
            List<DynamicComment> commentList = data.getSub();
            if (commentList != null&&!commentList.isEmpty()) {
                commentRecyclerView.setVisibility(View.VISIBLE);
                adapter.refreshData(commentList);
            }else {
                commentRecyclerView.setVisibility(View.GONE);
            }
        } else {
            commentRecyclerView.setVisibility(View.GONE);
        }

    }




    @Override
    public void onClick(View view) {
        switch (view.getId()) {
            case R.id.send_btn:
                startReply(view);
                break;
        }
    }

    //删除单条动态
    private void showDeleteDynamicTip(int position){
        new RightAlertDialog.Builder(mContext).setTitle("提示").setMsg("确定删除此动态？").setOk("确定").setCancel("取消").setClickListener(new RightAlertDialog.OnClickListener() {
            @Override
            public void onOkClick() {
                deleteDynamicComment(position);
            }
            @Override
            public void onCancelClick() {

            }
            @Override
            public void onDismiss() {

            }
        }).create();
    }
    //删除单条回复
    private void showDeleteReplyTip(int parentPosition,int position){
        List<TypeSelect> listPlanType=new ArrayList<>();
        listPlanType.add(new TypeSelect("copy","复制"));
        listPlanType.add(new TypeSelect("delete","删除"));
        new PlanTypeSelectDialog.Builder(mContext).setOk("确认").setCancel("取消").setMsg(listPlanType).setClickListener(new PlanTypeSelectDialog.OnClickListener() {
            @Override
            public void onOkClick(TypeSelect typeSelect) {
                if(typeSelect.getType().equals("copy")){
                    AppUtils.copy2clipboard(mContext,"标题");
                    ToastUtils.show("内容已复制到粘贴板");
                }else if(typeSelect.getType().equals("delete")){
                    deleteReplyDynamicComment(parentPosition,position);
                }
            }
            @Override
            public void onCancelClick() {

            }
            @Override
            public void onDismiss() {}
        }).create();
    }
    private View.OnLongClickListener longClickListener=new View.OnLongClickListener() {
        @Override
        public boolean onLongClick(View v) {
            int parentPosition= (int) v.getTag(CommonKey.KEY_POSITION);
            int position=(int) v.getTag(CommonKey.KEY_COMMENT_DYNAMIC_DATA);
            //RecyclerView mRecycler=recyclerView.getLayoutManager().findViewByPosition(parentPosition).findViewById(R.id.comment_recyclerview);
            if(mDatas.get(parentPosition).getMember_id().equals(memberId)){//是自己发布的动态才能删除
                showDeleteReplyTip(parentPosition, position);
                return false;
            }
            return false;
        }
    };
    private View.OnClickListener listener=new View.OnClickListener() {
        @Override
        public void onClick(View v) {
            DynamicComment data= (DynamicComment) v.getTag(CommonKey.KEY_COMMENT_DYNAMIC_DATA);
            int parentPosition= (int) v.getTag(CommonKey.KEY_POSITION);
            showCommentPop(CommonKey.KEY_COMMENT_DYNAMIC_REPLY,v,parentPosition,data);
        }
    };
    private void startReply(View view) {
        if (TextUtils.isEmpty(input_edit.getText().toString())) {
            Toast.makeText(view.getContext(), "输入内容不可以为空", Toast.LENGTH_SHORT).show();
            return;
        }
        DynamicComment tag = (DynamicComment) view.getTag(CommonKey.KEY_COMMENT_DYNAMIC_DATA);
        int dynamicCommentType= (int) view.getTag(CommonKey.KEY_COMMENT_DYNAMIC_TYPE);
        int position= (int) view.getTag(CommonKey.KEY_POSITION);
        addDynamicComment(view,dynamicCommentType,position,tag);

    }
    private AbsBaseActivity activity;
    private View commentView;
    private int commentViewY;
    private TextView send_btn;
    private EditText input_edit;
    private PopupWindow popupWindow;
    private LayoutInflater inflater;
    private RecyclerView recyclerView;
    private InputMethodManager inputManager;
    private void initCommentPop() {
        commentView = inflater.inflate(R.layout.layout_comment_pop, null);
        LinearLayout.LayoutParams params = new LinearLayout.LayoutParams(LinearLayout.LayoutParams.MATCH_PARENT, LinearLayout.LayoutParams.WRAP_CONTENT);
        params.gravity = Gravity.BOTTOM;
        commentView.setLayoutParams(params);
        input_edit = (EditText) commentView.findViewById(R.id.input_edit);
        send_btn = (TextView) commentView.findViewById(R.id.send_btn);
        send_btn.setOnClickListener(this);
        popupWindow = new PopupWindow(commentView, params.width, params.height);
        // 设置动画 commentPopup.setAnimationStyle(R.style.popWindow_animation_in2out);
        // 使其聚集 ，要想监听菜单里控件的事件就必须要调用此方法
        popupWindow.setFocusable(true);
        // 设置允许在外点击消失
        popupWindow.setOutsideTouchable(true);
        // 设置背景，这个是为了点击“返回Back”也能使其消失，并且并不会影响你的背景
        popupWindow.setBackgroundDrawable(new ColorDrawable());
    }
    //commentType 表示直接评论还是回复
    private void showCommentPop(int commentType,final View view,int position,DynamicComment data) {
        if (popupWindow != null && !popupWindow.isShowing()) {
            send_btn.setTag(CommonKey.KEY_POSITION,position);
            send_btn.setTag(CommonKey.KEY_COMMENT_DYNAMIC_TYPE,commentType);
            send_btn.setTag(CommonKey.KEY_COMMENT_DYNAMIC_DATA,data);
            if(data.getMy_name()!=null){
                input_edit.setHint("回复:"+data.getMy_name());
            }
            popupWindow.update();
            popupWindow.setSoftInputMode(WindowManager.LayoutParams.SOFT_INPUT_ADJUST_RESIZE);
            popupWindow.showAtLocation(view, Gravity.BOTTOM, 0, 0);
            inputManager.toggleSoftInput(0, InputMethodManager.HIDE_NOT_ALWAYS);
            int[] viewLocation = new int[2];
            view.getLocationOnScreen(viewLocation);
            final int viewY = viewLocation[1];
            // 避免每次都延迟滚动到指定位置，所以记录第一次获取到的评论框的位置
            // 延迟的目的是留足够的时间让评论框弹出来
            if (commentViewY == 0 || commentViewY == (ScreenUtils.getScreenHeight(activity) - commentView.getHeight())) {
                view.postDelayed(new Runnable() {
                    @Override
                    public void run() {
                        Rect r = new Rect();
                        activity.getWindow().getDecorView().getWindowVisibleDisplayFrame(r);
                        commentViewY = r.bottom - popupWindow.getContentView().getMeasuredHeight();
                        int offsetY =  viewY - commentViewY + view.getHeight();
                        recyclerView.smoothScrollBy(0, offsetY);
                    }
                }, 500);
            } else {
                int offsetY =  viewY - commentViewY + view.getHeight();
                recyclerView.smoothScrollBy(0, offsetY);
            }
        }
    }

    //添加评论
    private void addDynamicComment(View view,int dynamicCommentType,int position,DynamicComment data){
        activity.showProgressDialog();
        HashMap<String,String> hashMap=new HashMap<>();
        hashMap.put("member_id",memberId);
        if(dynamicCommentType==CommonKey.KEY_COMMENT_DYNAMIC){
            hashMap.put("id",data.getId());
        }else if(dynamicCommentType==CommonKey.KEY_COMMENT_DYNAMIC_REPLY){
            hashMap.put("id",data.getId());
        }
        hashMap.put("content",input_edit.getText().toString().trim());
        Disposable disposable= HttpUtil.getInstance().post(HttpUrl.api_add_reply_dynamic,hashMap,new DisposableObserver<String>(){
            @Override
            public void onNext(String o) {
                try {
                    JSONObject jsonObject=new JSONObject(o);
                    DynamicComment dynamicComment= GsonUtil.getObject(jsonObject.getString("record"),DynamicComment.class);
                    dynamicComment.setIs_like("0");
                    dynamicComment.setLikes("0");
                    /*RecyclerView mRecycler=recyclerView.getLayoutManager().findViewByPosition(position).findViewById(R.id.comment_recyclerview);
                    ((DynamicReplyListAdapter)mRecycler.getAdapter()).getDatas().add(dynamicComment);*/
                    mDatas.get(position).getSub().add(dynamicComment);
                    recyclerView.getAdapter().notifyDataSetChanged();

                } catch (JSONException e) {
                    e.printStackTrace();
                }
                input_edit.setText("");
                if (popupWindow.isShowing()) {
                    popupWindow.dismiss();
                    inputManager.hideSoftInputFromWindow(view.getWindowToken(), 0);
                }
                activity.dismissProgressDialog();
            }

            @Override
            public void onError(Throwable e) {
                activity.dismissProgressDialog();
                ToastUtils.show("发布评论失败");
            }

            @Override
            public void onComplete() {

            }
        },String.class);
    }

    //删除评论
    private void deleteDynamicComment(int position){
        activity.showProgressDialog();
        String id=mDatas.get(position).getId();
        HashMap<String,String> hashMap=new HashMap<>();
        hashMap.put("member_id",memberId);
        hashMap.put("id",id);
        Disposable disposable= HttpUtil.getInstance().post(HttpUrl.api_delete_dynamic,hashMap,new DisposableObserver<String>(){
            @Override
            public void onNext(String o) {
                mDatas.remove(position);
                recyclerView.getAdapter().notifyDataSetChanged();
                activity.dismissProgressDialog();
            }

            @Override
            public void onError(Throwable e) {
                activity.dismissProgressDialog();
                ToastUtils.show(e.getMessage());
            }

            @Override
            public void onComplete() {

            }
        },String.class);
    }


    private void deleteReplyDynamicComment(int parentPosition,int position){
        activity.showProgressDialog();
        HashMap<String,String> hashMap=new HashMap<>();
        String id=getDatas().get(parentPosition).getSub().get(position).getId();
        hashMap.put("member_id",memberId);
        hashMap.put("id",id);
        Disposable disposable= HttpUtil.getInstance().post(HttpUrl.api_delete_dynamic,hashMap,new DisposableObserver<String>(){
            @Override
            public void onNext(String o) {
                /*adapter.getDatas().remove(position);
                adapter.notifyItemChanged(position);*/
                mDatas.get(parentPosition).getSub().remove(position);
                /*if(headerAndFooterWrapper!=null){
                    recyclerView.getAdapter().notifyItemChanged(parentPosition-headerAndFooterWrapper.getHeadersCount());
                }else {
                    recyclerView.getAdapter().notifyItemChanged(parentPosition);
                }*/
                recyclerView.getAdapter().notifyDataSetChanged();
                activity.dismissProgressDialog();
            }

            @Override
            public void onError(Throwable e) {
                activity.dismissProgressDialog();
                ToastUtils.show(e.getMessage());
            }

            @Override
            public void onComplete() {

            }
        },String.class);
    }



    //点赞/取消点赞
    private void likeDynamicComment(int position){
        activity.showProgressDialog();
        HashMap<String,String> hashMap=new HashMap<>();
        String id=getDatas().get(position).getId();
        hashMap.put("member_id",memberId);
        hashMap.put("id",id);
        DynamicComment data=mDatas.get(position);
        String url=null;
        if(data.getIs_like().equals("0")){
            url=HttpUrl.api_dynamic_like;
        }else {
            url=HttpUrl.api_dynamic_unlike;
        }
        Disposable disposable= HttpUtil.getInstance().post(url,hashMap,new DisposableObserver<String>(){
            @Override
            public void onNext(String o) {
                if(data.getIs_like().equals("0")){
                    int likeNum=Integer.parseInt(data.getLikes());
                    likeNum++;
                    mDatas.get(position).setLikes(likeNum+"");
                    mDatas.get(position).setIs_like("1");
                }else {
                    int likeNum=Integer.parseInt(data.getLikes());
                    likeNum--;
                    mDatas.get(position).setLikes(likeNum+"");
                    mDatas.get(position).setIs_like("0");
                }
                notifyItemChanged(position);
                recyclerView.getAdapter().notifyDataSetChanged();
                activity.dismissProgressDialog();
            }

            @Override
            public void onError(Throwable e) {
                activity.dismissProgressDialog();
                ToastUtils.show(e.getMessage());
            }

            @Override
            public void onComplete() {

            }
        },String.class);
    }
}
