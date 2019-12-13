package ticketrecognition.web.cti;

import com.bfh.ticket.*;
import com.bfh.ticket.exception.CtiException;

import java.util.Optional;
import java.util.logging.Logger;

public class MatcherService {

    private static final Logger LOG = Logger.getLogger(MatcherService.class.getName());

    private final Matcher matcher;

    public MatcherService() {
        this.matcher = new Matcher(Algorithm.SIFT);
    }

    public void train(Ticket ticket) {
        try {
            matcher.train(ticket);
        } catch (CtiException exc) {
            LOG.severe(exc.getMessage());
        }
    }

    public Optional<TicketMatch> match(TicketImage image) {
        return matcher.match(image);
    }
}
