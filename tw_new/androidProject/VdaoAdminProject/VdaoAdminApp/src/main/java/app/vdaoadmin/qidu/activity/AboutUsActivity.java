package app.vdaoadmin.qidu.activity;

import android.os.Build;
import android.os.Bundle;
import android.view.View;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.common.lib.base.AbsBaseActivity;
import com.common.lib.utils.ScreenUtils;

import app.vdaoadmin.qidu.R;

/**
 * Created by 7du-28 on 2018/4/28.
 */

public class AboutUsActivity extends AbsBaseActivity{

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_about_us);

        ImageView back=findViewById(R.id.header_left_btn_img);
        back.setColorFilter(getResources().getColor(R.color.black));
        back.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });
        TextView titleCenter=findViewById(R.id.header_text);
        titleCenter.setTextColor(getResources().getColor(R.color.black));
        titleCenter.setText("关于V稻");
        ImageView status_view= (ImageView) findViewById(R.id.status_view);
        status_view.setImageDrawable(null);
        View status_view_layout=findViewById(R.id.status_bar_layout);
        status_view.setBackgroundColor(getResources().getColor(R.color.white));
        status_view_layout.setBackgroundColor(getResources().getColor(R.color.white));
        View title_parent_top=findViewById(R.id.title_parent_top);
        title_parent_top.setBackground(null);
        title_parent_top.setBackgroundColor(getResources().getColor(R.color.white));
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.KITKAT) {
            setTranslucentStatus(true);
            LinearLayout.LayoutParams params= (LinearLayout.LayoutParams) status_view.getLayoutParams();
            params.height= ScreenUtils.getStatusBarHeight(this);
            //params.setMargins(0, ScreenUtils.getStatusBarHeight(this), 0, 0);
            status_view.setLayoutParams(params);
            status_view_layout.setVisibility(View.VISIBLE);
        }
    }
}
