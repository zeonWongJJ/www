package app.odp.qidu.activity;

import android.support.v7.widget.DefaultItemAnimator;
import android.support.v7.widget.GridLayoutManager;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;

import com.common.lib.basemvp.base.BaseActivity;
import com.luck.picture.lib.decoration.GridSpacingItemDecoration;
import com.common.lib.basemvp.presenter.BasePresenter;

import app.odp.qidu.R;
import app.odp.qidu.adapter.PlanShowFileAdapter;
import app.odp.qidu.adapter.PlanShowImgAdapter;

/**
 * 计划图片文件显示
 */

public abstract class BaseShowImgAndFileActivity <T extends BasePresenter> extends BaseActivity<T> {
    protected RecyclerView picRecyclerView;
    protected PlanShowImgAdapter imgAdapter;
    protected RecyclerView fileRecyclerView;
    protected PlanShowFileAdapter fileAdapter;
    protected void initPictureAndFile(){
        /*图片展示*/
        picRecyclerView=findView(R.id.recycler_img);
        picRecyclerView.setNestedScrollingEnabled(false);
        picRecyclerView.setHasFixedSize(true);
        GridLayoutManager gridManager = new GridLayoutManager(getActivity(), 4, GridLayoutManager.VERTICAL, false);
        picRecyclerView.setLayoutManager(gridManager);
        GridSpacingItemDecoration itemDecoration=new GridSpacingItemDecoration(4,10,false);
        picRecyclerView.addItemDecoration(itemDecoration);
        ((DefaultItemAnimator) picRecyclerView.getItemAnimator()).setSupportsChangeAnimations(false);
        imgAdapter=new PlanShowImgAdapter(getActivity());
        picRecyclerView.setAdapter(imgAdapter);

        /*文件展示*/
        fileRecyclerView=findView(R.id.recycler_file);
        fileAdapter=new PlanShowFileAdapter(getActivity());
        fileRecyclerView.setNestedScrollingEnabled(false);
        fileRecyclerView.setHasFixedSize(true);
        fileRecyclerView.setLayoutManager(new LinearLayoutManager(getActivity()));
        ((DefaultItemAnimator) fileRecyclerView.getItemAnimator()).setSupportsChangeAnimations(false);
        fileRecyclerView.setAdapter(fileAdapter);
    }


}
