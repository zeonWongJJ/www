package app.odp.qidu.fragment;

import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v7.widget.DefaultItemAnimator;
import android.support.v7.widget.GridLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import com.app.base.bean.TypeSelect;
import com.common.lib.base.AbsBaseFragment;
import com.luck.picture.lib.decoration.GridSpacingItemDecoration;

import java.util.ArrayList;
import java.util.List;

import app.odp.qidu.R;
import app.odp.qidu.adapter.MoreGridAdapter;
import app.odp.qidu.adapter.ThingRecordGridAdapter;

/**
 * 更多
 */

public class TabMoreFragment extends AbsBaseFragment{
    private String param;
    private RecyclerView record_grid;
    public static TabMoreFragment getInstance(String param) {
        TabMoreFragment sf = new TabMoreFragment();
        sf.param = param;
        return sf;
    }
    @Nullable
    @Override
    public View onCreateView(LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        return inflater.inflate(R.layout.fragment_tab_more,container,false);
    }

    @Override
    public void onViewCreated(View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);
        TextView titleCenter=view.findViewById(R.id.title_center_text);
        titleCenter.setText("更多");
        record_grid=view.findViewById(R.id.record_grid);

        record_grid.setNestedScrollingEnabled(false);
        record_grid.setHasFixedSize(true);
        GridLayoutManager gridManager = new GridLayoutManager(getActivity(), 4, GridLayoutManager.VERTICAL, false);
        record_grid.setLayoutManager(gridManager);
        GridSpacingItemDecoration itemDecoration=new GridSpacingItemDecoration(4,10,false);
        record_grid.addItemDecoration(itemDecoration);
        ((DefaultItemAnimator) record_grid.getItemAnimator()).setSupportsChangeAnimations(false);
        MoreGridAdapter thingRecordGridAdapter=new MoreGridAdapter(getActivity());
        record_grid.setAdapter(thingRecordGridAdapter);

        List<TypeSelect> listRecord=new ArrayList<>();
        TypeSelect attendanceBean=new TypeSelect("notice","公告通知");
        TypeSelect leaveBean=new TypeSelect("dynamic","动态圈");
        listRecord.add(attendanceBean);
        listRecord.add(leaveBean);
        thingRecordGridAdapter.refreshData(listRecord);

    }
}
