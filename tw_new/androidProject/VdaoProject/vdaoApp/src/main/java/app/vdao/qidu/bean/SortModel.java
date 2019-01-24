package app.vdao.qidu.bean;

import com.amap.api.services.core.LatLonPoint;

public class SortModel {

	private String name; // 显示的数据
	private String sortLetters; // 显示数据拼音的首字母
	private String cityCode;

	private LatLonPoint latLonPoint;

	public LatLonPoint getLatLonPoint() {
		return latLonPoint;
	}

	public void setLatLonPoint(LatLonPoint latLonPoint) {
		this.latLonPoint = latLonPoint;
	}

	public SortModel() {

	}



	public String getCityCode() {
		return cityCode;
	}

	public void setCityCode(String cityCode) {
		this.cityCode = cityCode;
	}

	public String getName() {
		return name;
	}

	public void setName(String name) {
		this.name = name;
	}

	public String getSortLetters() {
		return sortLetters;
	}

	public void setSortLetters(String sortLetters) {
		this.sortLetters = sortLetters;
	}


}