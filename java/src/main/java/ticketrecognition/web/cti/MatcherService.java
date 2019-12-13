package ticketrecognition.web.cti;

import com.bfh.ticket.*;

import java.util.Optional;

public class MatcherService {

    private final Matcher matcher;

    public MatcherService() {
        this.matcher = new Matcher(Algorithm.SIFT);
    }

    public void train(Ticket ticket) {
        matcher.train(ticket);
    }

    public Optional<TicketMatch> match(TicketImage image) {
        return matcher.match(image);
    }
}
