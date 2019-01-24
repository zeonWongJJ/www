package app.vdaoadmin.qidu.activity;

import android.os.Build;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.text.TextUtils;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.app.base.bean.User;
import com.app.base.utils.HttpUrl;
import com.app.base.utils.IntentParams;
import com.bumptech.glide.Glide;
import com.bumptech.glide.request.RequestOptions;
import com.common.lib.utils.ScreenUtils;
import com.common.lib.utils.TimeUtil;
import com.mvp.lib.base.BaseActivity;
import com.mvp.lib.presenter.BasePresenter;
import com.mvp.lib.view.IBaseActivityView;

import app.vdaoadmin.qidu.R;

/**
 * 用户详情
 */

public class UserDetailActivity extends BaseActivity<BasePresenter> implements IBaseActivityView{
    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {ImageView status_view= (ImageView) findViewById(R.id.status_view);
        View status_view_layout=findViewById(R.id.status_bar_layout);
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.KITKAT) {
            setTranslucentStatus(true);
            LinearLayout.LayoutParams params= (LinearLayout.LayoutParams) status_view.getLayoutParams();
            params.height= ScreenUtils.getStatusBarHeight(this);
            //params.setMargins(0, ScreenUtils.getStatusBarHeight(this), 0, 0);
            status_view.setLayoutParams(params);
            status_view_layout.setVisibility(View.VISIBLE);
        }
        TextView titleCenter=findView(R.id.header_text);
        titleCenter.setText("用户详情");
        View back=findView(R.id.header_left_btn_img);
        back.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });
        User user= (User) getIntent().getParcelableExtra(IntentParams.KEY_USER_INFO);
        if(user!=null){
            ImageView user_photo=findView(R.id.user_photo);
            if(!TextUtils.isEmpty(user.getUser_pic())){
                RequestOptions options=new RequestOptions();
                options.apply(RequestOptions.circleCropTransform());
                options.placeholder(R.drawable.icon_default_user_detail);
                options.error(R.drawable.icon_default_user_detail);
                String url=user.getUser_pic().startsWith("http:")?user.getUser_pic():HttpUrl.API_HOST+user.getUser_pic();
                Glide.with(this)
                        .load(url)
                        .apply(options)
                        .into(user_photo);
            }else {
                user_photo.setImageDrawable(getResources().getDrawable(R.drawable.icon_default_user_detail));
            }

            TextView user_name=findView(R.id.user_name);
            user_name.setText(user.getUser_name());
            TextView user_phone_num=findView(R.id.user_phone_num);
            user_phone_num.setText("手机号："+user.getUser_phone());
            TextView user_sex=findView(R.id.user_sex);
            if(user.getUser_sex().equals("1")){
                user_sex.setText("性别：男");
            }else if(user.getUser_sex().equals("2")){
                user_sex.setText("性别：女");
            }else {
                user_sex.setText("性别：未知");
            }
            TextView user_email=findView(R.id.user_email);
            user_email.setText(user.getUser_email());
            ImageView wechat_bind=findView(R.id.wechat_bind);
            if(TextUtils.isEmpty(user.getWeixin_openid())){
                wechat_bind.setImageDrawable(getResources().getDrawable(R.drawable.icon_wechat_unselect));
            }else{
                wechat_bind.setImageDrawable(getResources().getDrawable(R.drawable.icon_wechat_select));
            }
            ImageView qq_bind=findView(R.id.qq_bind);
            if(TextUtils.isEmpty(user.getQq_openid())){
                qq_bind.setImageDrawable(getResources().getDrawable(R.drawable.icon_qq_unselect));
            }else{
                qq_bind.setImageDrawable(getResources().getDrawable(R.drawable.icon_qq_select));
            }
            TextView user_score=findView(R.id.user_score);
            user_score.setText(user.getUser_score());
            TextView user_balance=findView(R.id.user_balance);
            user_balance.setText(user.getUser_balance());
            TextView user_regtime=findView(R.id.user_regtime);
            user_regtime.setText(TimeUtil.getTime(Long.parseLong(user.getUser_regtime())*1000,"yyyy-MM-dd"));
        }


    }

    @NonNull
    @Override
    protected View initView(@NonNull LayoutInflater inflater, Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.activity_user_detail, null);
        return view;
    }

    @Override
    protected BasePresenter initPresenter() {
        return new BasePresenter() {
            @Override
            public void onCreate() {

            }

            @Override
            public void loadData() {

            }
        };
    }


}
