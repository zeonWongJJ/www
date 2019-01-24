package app.vdaoadmin.qidu.adapter;

import android.content.Context;
import android.view.View;
import android.widget.AbsListView;
import android.widget.ImageView;
import android.widget.TextView;

import com.amap.api.services.core.PoiItem;
import com.app.base.utils.DataUtils;
import com.app.base.widget.CircleProgress;
import com.common.lib.adapter.AdapterHolder;
import com.common.lib.adapter.BaseListAndGridAdapter;

import java.util.Collection;

import app.vdaoadmin.qidu.R;
import app.vdaoadmin.qidu.bean.HomeGridItem;


public class MonthGridAdapter extends BaseListAndGridAdapter<HomeGridItem> {
    private Context context;
    public MonthGridAdapter(Context context,AbsListView view, Collection<HomeGridItem> mDatas) {
        super(view, mDatas, R.layout.layout_month_add_item);
        this.context=context;
    }

    @Override
    public void convert(AdapterHolder holder, int position, boolean isScrolling) {
        HomeGridItem data=getItem(position);
        if(data==null){
            return;
        }
        TextView month_increase_count=holder.getView(R.id.month_increase_count);
        TextView last_month_count=holder.getView(R.id.last_month_count);
        TextView this_month_count=holder.getView(R.id.this_month_count);
        CircleProgress pv=holder.getView(R.id.increase_progress);
        TextView order_title=holder.getView(R.id.order_title);
        //1订单 2用户 3门店 4店主
        if(data.getItemType()==1){
            pv.setTextColor(context.getResources().getColor(R.color.home_red_color));
            pv.setProgress(context.getResources().getColor(R.color.home_red_color));
            month_increase_count.setTextColor(context.getResources().getColor(R.color.home_red_color));
            order_title.setText("月订单增长");
        }else if(data.getItemType()==2){
            pv.setTextColor(context.getResources().getColor(R.color.home_yellow_color));
            pv.setProgress(context.getResources().getColor(R.color.home_yellow_color));
            month_increase_count.setTextColor(context.getResources().getColor(R.color.home_yellow_color));
            order_title.setText("月用户增长");
        }else if(data.getItemType()==3){
            pv.setTextColor(context.getResources().getColor(R.color.home_green_color));
            pv.setProgress(context.getResources().getColor(R.color.home_green_color));
            month_increase_count.setTextColor(context.getResources().getColor(R.color.home_green_color));
            order_title.setText("月门店增长");
        }else if(data.getItemType()==4){
            pv.setTextColor(context.getResources().getColor(R.color.home_blue_color));
            pv.setProgress(context.getResources().getColor(R.color.home_blue_color));
            month_increase_count.setTextColor(context.getResources().getColor(R.color.home_blue_color));
            order_title.setText("月店主增长");
        }

        String last= DataUtils.addComma(data.getLastMonth());
        String thisM=DataUtils.addComma(data.getThisMonth());
        last_month_count.setText("上月："+last);
        this_month_count.setText("本月："+thisM);
        int lastMonth=Integer.parseInt(data.getLastMonth());
        int thisMonth=Integer.parseInt(data.getThisMonth());
        int increase=thisMonth-lastMonth;

        if(increase>0){
            month_increase_count.setText(DataUtils.addComma(increase+""));
            int value=(increase/thisMonth)*100;
            pv.setValue(value);
        }else {
            month_increase_count.setText(0+"");
            pv.setValue(0);
        }
    }

}
