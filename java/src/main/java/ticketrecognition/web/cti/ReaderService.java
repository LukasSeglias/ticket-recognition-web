package ticketrecognition.web.cti;

import com.bfh.ticket.*;
import com.bfh.ticket.exception.CtiException;

import java.util.logging.Logger;

import static com.bfh.ticket.MetadataReaderOptions.USE_DEFAULT_RATIO_THRESHOLD;

public class ReaderService {

    private static final Logger LOG = Logger.getLogger(ReaderService.class.getName());

    private final MetadataReader reader;

    public ReaderService() {
        this.reader = new MetadataReader(Algorithm.SIFT, new MetadataReaderOptions(USE_DEFAULT_RATIO_THRESHOLD, "deu"));
    }

    public Metadata read(Ticket ticket, TicketImage ticketImage) {
        try {
            return reader.read(ticket, ticketImage);
        } catch (CtiException exc) {
            LOG.severe(exc.getMessage());
        }

        return null;
    }
}
