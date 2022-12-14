/****** Object:  Table [dbo].[proveedor]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[proveedor](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[idfiscal] [varchar](18) NULL,
	[proveedor] [varchar](120) NULL,
	[pais] [varchar](250) NULL,
	[moneda] [varchar](3) NULL,
	[valormoneda] [decimal](18, 6) NULL,
	[valordolares] [decimal](18, 2) NULL,
	[domicilio_id] [int] NULL,
	[licencia] [int] NULL,
 CONSTRAINT [PK_proveedor] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
