package app.vdao.qidu.common;

import com.gzqx.common.bean.Store;

import java.util.Comparator;

public class PinyinStoreComparator implements Comparator<Store> {

	public int compare(Store o1, Store o2) {
		if (o1.getSortLetters().equals("@") || o2.getSortLetters().equals("#")) {
			return -1;
		} else if (o1.getSortLetters().equals("#")
				|| o2.getSortLetters().equals("@")) {
			return 1;
		} else {
			return o1.getSortLetters().compareTo(o2.getSortLetters());
		}
	}

}
