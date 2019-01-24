package app.vdaoadmin.qidu.adapter;

import android.widget.AbsListView;

import com.common.lib.adapter.AdapterHolder;
import com.common.lib.adapter.BaseListAndGridAdapter;

import java.util.Collection;

import app.vdaoadmin.qidu.R;
import app.vdaoadmin.qidu.bean.Goods;


public class LunchDetailItemAdapter extends BaseListAndGridAdapter<Goods> {

    public LunchDetailItemAdapter(AbsListView view, Collection<Goods> mDatas) {
        super(view, mDatas, R.layout.layout_lunch_detail_item);
    }

    @Override
    public void convert(AdapterHolder holder, int position, boolean isScrolling) {
        Goods data=getItem(position);
        holder.setText(R.id.product_name,""+data.getProduct_name());
        holder.setText(R.id.num,"x"+data.getGoods_num());
        holder.setText(R.id.money,"￥"+data.getMoney());
        holder.setText(R.id.spec,""+data.getSpec());
    }
}
