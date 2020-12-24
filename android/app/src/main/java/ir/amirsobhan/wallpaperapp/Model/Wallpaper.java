package ir.amirsobhan.wallpaperapp.Model;

import com.google.gson.annotations.SerializedName;

public class Wallpaper {
    @SerializedName("id")
    private int id;

    @SerializedName("title")
    private String title;

    @SerializedName("des")
    private String des;

    @SerializedName("tags")
    private String tags;

    @SerializedName("category")
    private String category;

    @SerializedName("likes")
    private int likeCount;

    @SerializedName("views")
    private int viewCount;

    @SerializedName("downloads")
    private int downloadCount;

    @SerializedName("author")
    private String author;

    @SerializedName("path")
    private String path;

    @SerializedName("temp")
    private String tempUrl;

    @SerializedName("wallpaper")
    private String wallpaperUrl;

    public Wallpaper(int id, String title, String des, String tags, String category, int likeCount, int viewCount, int downloadCount, String author, String path, String tempUrl, String wallpaperUrl) {
        this.id = id;
        this.title = title;
        this.des = des;
        this.tags = tags;
        this.category = category;
        this.likeCount = likeCount;
        this.viewCount = viewCount;
        this.downloadCount = downloadCount;
        this.author = author;
        this.path = path;
        this.tempUrl = tempUrl;
        this.wallpaperUrl = wallpaperUrl;
    }

    public Wallpaper(String title, String des, String tags, String category, int likeCount, int viewCount, int downloadCount, String author, String path, String tempUrl, String wallpaperUrl) {
        this.title = title;
        this.des = des;
        this.tags = tags;
        this.category = category;
        this.likeCount = likeCount;
        this.viewCount = viewCount;
        this.downloadCount = downloadCount;
        this.author = author;
        this.path = path;
        this.tempUrl = tempUrl;
        this.wallpaperUrl = wallpaperUrl;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getTitle() {
        return title;
    }

    public void setTitle(String title) {
        this.title = title;
    }

    public String getDes() {
        return des;
    }

    public void setDes(String des) {
        this.des = des;
    }

    public String getTags() {
        return tags;
    }

    public void setTags(String tags) {
        this.tags = tags;
    }

    public int getLikeCount() {
        return likeCount;
    }

    public void setLikeCount(int likeCount) {
        this.likeCount = likeCount;
    }

    public int getViewCount() {
        return viewCount;
    }

    public void setViewCount(int viewCount) {
        this.viewCount = viewCount;
    }

    public int getDownloadCount() {
        return downloadCount;
    }

    public void setDownloadCount(int downloadCount) {
        this.downloadCount = downloadCount;
    }

    public String getAuthor() {
        return author;
    }

    public void setAuthor(String author) {
        this.author = author;
    }

    public String getPath() {
        return path;
    }

    public void setPath(String path) {
        this.path = path;
    }

    public String getTempUrl() {
        return tempUrl;
    }

    public void setTempUrl(String tempUrl) {
        this.tempUrl = tempUrl;
    }

    public String getWallpaperUrl() {
        return wallpaperUrl;
    }

    public void setWallpaperUrl(String wallpaperUrl) {
        this.wallpaperUrl = wallpaperUrl;
    }

    public String getCategory() {
        return category;
    }

    public void setCategory(String category) {
        this.category = category;
    }
}
