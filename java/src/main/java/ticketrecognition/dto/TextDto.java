package ticketrecognition.dto;

public class TextDto {
    private String key;
    private PointDto topLeft;
    private PointDto bottomRight;

    public String getKey() {
        return key;
    }

    public void setKey(String key) {
        this.key = key;
    }

    public PointDto getTopLeft() {
        return topLeft;
    }

    public void setTopLeft(PointDto topLeft) {
        this.topLeft = topLeft;
    }

    public PointDto getBottomRight() {
        return bottomRight;
    }

    public void setBottomRight(PointDto bottomRight) {
        this.bottomRight = bottomRight;
    }
}
