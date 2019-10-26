package ticketrecognition.web;

public class TestClass {

    private Long id;
    private String test;
    private OtherClass other;

    public Long getId() {
        return id;
    }

    public void setId(Long id) {
        this.id = id;
    }

    public String getTest() {
        return test;
    }

    public void setTest(String test) {
        this.test = test;
    }

    public OtherClass getOther() {
        return other;
    }

    public void setOther(OtherClass other) {
        this.other = other;
    }

    public static class OtherClass {

        private String name;

        public String getName() {
            return name;
        }

        public void setName(String name) {
            this.name = name;
        }
    }
}
