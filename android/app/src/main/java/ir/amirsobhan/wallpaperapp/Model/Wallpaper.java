package ir.amirsobhan.wallpaperapp.Model;

import com.google.gson.annotations.Expose;
import com.google.gson.annotations.SerializedName;

public class Wallpaper {

    @SerializedName("id")
    @Expose
    private int id;
    @SerializedName("title")
    @Expose
    private String title;
    @SerializedName("tags")
    @Expose
    private String tags;
    @SerializedName("likes")
    @Expose
    private int likes;
    @SerializedName("views")
    @Expose
    private int views;
    @SerializedName("downloads")
    @Expose
    private int downloads;
    @SerializedName("author")
    @Expose
    private String author;
    @SerializedName("path")
    @Expose
    private String path;
    @SerializedName("temp")
    @Expose
    private String temp;
    @SerializedName("wallpaper")
    @Expose
    private String wallpaper;

    public Wallpaper(int id, String title, String tags, int likes, int views, int downloads, String author, String path, String temp, String wallpaper) {
        this.id = id;
        this.title = title;
        this.tags = tags;
        this.likes = likes;
        this.views = views;
        this.downloads = downloads;
        this.author = author;
        this.path = path;
        this.temp = temp;
        this.wallpaper = wallpaper;
    }

    public Wallpaper(String title, String tags, int likes, int views, int downloads, String author, String path, String temp, String wallpaper) {
        this.title = title;
        this.tags = tags;
        this.likes = likes;
        this.views = views;
        this.downloads = downloads;
        this.author = author;
        this.path = path;
        this.temp = temp;
        this.wallpaper = wallpaper;
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

    public String getTags() {
        return tags;
    }

    public void setTags(String tags) {
        this.tags = tags;
    }

    public int getLikes() {
        return likes;
    }

    public void setLikes(int likes) {
        this.likes = likes;
    }

    public int getViews() {
        return views;
    }

    public void setViews(int views) {
        this.views = views;
    }

    public int getDownloads() {
        return downloads;
    }

    public void setDownloads(int downloads) {
        this.downloads = downloads;
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

    public String getTemp() {
        return temp;
    }

    public void setTemp(String temp) {
        this.temp = temp;
    }

    public String getWallpaper() {
        return wallpaper;
    }

    public void setWallpaper(String wallpaper) {
        this.wallpaper = wallpaper;
    }

}